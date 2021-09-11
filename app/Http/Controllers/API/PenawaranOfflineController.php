<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\PenawaranOfflineResourceController;
use App\Models\KomponenPenawaranOffline;
use App\Models\PathPhotoPenawaranOffline;
use App\Models\PenawaranOffline;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PenawaranOfflineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|object
     */
    public function index()
    {
        try {
            $data = PenawaranOffline::with('komponen', 'path')->where('kode_tukang', Auth::id())->paginate(10);
            return (new PenawaranOfflineResourceController($data))->response()->setStatusCode(200);
        } catch (ModelNotFoundException $e) {
            return (new PenawaranOfflineResourceController(['message' => 'Belum mempunyai item penawaran offline.']))->response()->setStatusCode(401);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|object
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_client' => 'required|string|max:50',
            'email_client' => 'string|max:50',
            'nomor_telepon_client' => 'required|string',
            'kota_client' => 'required|string|max:50',
            'alamat_client' => 'required|string|max:100',
            'nama_proyek' => 'required|string|max:100',
            'diskripsi_proyek' => 'required|string',
            'alamat_proyek' => 'required|string|max:100',
            'range_min' => 'required|integer',
            'range_max' => 'required|integer',
            'keuntungan' => 'required|integer',
            'deadline' => 'required|date',
            'nama_komponen' => 'required|array',
            'nama_komponen.*' => 'required|string',
            'harga_komponen' => 'required|array',
            'harga_komponen.*' => 'required|integer',
            'merk_type_komponen' => 'required|array',
            'merk_type_komponen.*' => 'required|string|max:50',
            'spesifikasi_komponen' => 'required|array',
            'spesifikasi_komponen.*' => 'required|string|max:80',
            'satuan_komponen' => 'required|array',
            'satuan_komponen.*' => 'required|string|max:20',
            'total_unit_komponen' => 'required|array',
            'total_unit_komponen.*' => 'required|integer',
            'path' => 'required|array',
            'path.*' => 'required|mimes:jpg,jpeg,png|max:1000'
        ]);

        if ($validator->fails()) {
            return (new PenawaranOfflineResourceController(['error' => $validator->errors()]))->response()->setStatusCode(401);
        }

        if (sizeof($request->input('nama_komponen')) !== sizeof($request->input('harga_komponen'))) {
            return (new PenawaranOfflineResourceController(['error' => 'nama_komponen not same length with harga_komponen !']))->response()->setStatusCode(401);
        }
        $tmp = array();
        try {
            DB::transaction(function () use ($tmp, $request, &$data) {

                $nama = $request->input('nama_komponen');
                $harga = $request->input('harga_komponen');
                $merk_type_komponen = $request->input('merk_type_komponen');
                $spesifikasi_komponen = $request->input('spesifikasi_komponen');
                $satuan_komponen = $request->input('satuan_komponen');
                $total_unit_komponen = $request->input('total_unit_komponen');
                $tt_harga = kalkulasiBiayaPenawaranOfflineBaru($request->input('keuntungan'), $harga);
                $request->request->add(['harga_total' => $tt_harga]);
                $request->request->add(['kode_tukang' => Auth::id()]);
                $data = PenawaranOffline::create(
                    $request->except([
                        'nama_komponen',
                        'harga_komponen',
                        'merk_type_komponen',
                        'spesifikasi_komponen',
                        'satuan_komponen',
                        'total_unit_komponen'
                    ]));

                $dump = null;
                for ($i = 0; $i < sizeof($nama); $i++) {
                    $komponen = new KomponenPenawaranOffline();
                    $komponen->kode_penawaran_offline = $data->id;
                    $komponen->nama_komponen = $nama[$i];
                    $komponen->harga = $harga[$i];
                    $komponen->merk_type = $merk_type_komponen[$i];
                    $komponen->spesifikasi_teknis = $spesifikasi_komponen[$i];
                    $komponen->satuan = $satuan_komponen[$i];
                    $komponen->total_unit = $total_unit_komponen[$i];
                    $komponen->save();
                    $dump[$i] = $komponen;
                }

                foreach ($request->file('path') as $file) {
                    if ($file->isValid()) {
                        $path = $file->store('images/penawaran/offline', 'public');
                        $path = substr($path, 6);
                        $path = "storage/images" . $path;

                        $mpath = new PathPhotoPenawaranOffline();
                        $mpath->kode_penawaran_offline = $data->id;
                        $mpath->path = $path;
                        $mpath->save();

                        array_push($tmp, $path);
                    }
                }

                $data['komponen'] = $dump;
                $data['path'] = $tmp;

            });
            return (new PenawaranOfflineResourceController($data))->response()->setStatusCode(200);
        } catch (ModelNotFoundException $e) {
            if (isset($tmp)) {
                foreach ($tmp as $path) {
                    Storage::delete($path);
                }
            }
            return (new PenawaranOfflineResourceController(['error' => $e->getMessage()]))->response()->setStatusCode(401);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|object
     */
    public function show($id)
    {
        try {

            if (!PenawaranOffline::where('id',$id)->exists()){
                return (new PenawaranOfflineResourceController(['error' => 'Item penawaran tidak ditemukan.']))->response()->setStatusCode(401);
            }

            $data = PenawaranOffline::with('tukang','komponen','path')->where('id', $id)->first();
            if (Auth::id() != $data->kode_tukang) {
                return (new PenawaranOfflineResourceController(['error' => 'Anda tidak mempunyai akses atas item penawaran ini !']))->response()->setStatusCode(401);
            }
            return (new PenawaranOfflineResourceController($data))->response()->setStatusCode(200);
        } catch (ModelNotFoundException $e) {
            return (new PenawaranOfflineResourceController(['error' => 'Item penawaran tidak ditemukan.']))->response()->setStatusCode(401);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|object
     */
    public function update(Request $request, $id)
    {
        if (!count($request->all())) {
            return (new PenawaranOfflineResourceController(['error' => 'mush have one input.']))->response()->setStatusCode(401);
        }

        $validator = Validator::make($request->all(), [
            'nama_client' => 'string|max:50',
            'email_client' => 'string|max:50',
            'nomor_telepon_client' => 'string',
            'kota_client' => 'string|max:50',
            'alamat_client' => 'string|max:100',
            'nama_proyek' => 'string|max:100',
            'diskripsi_proyek' => 'string',
            'alamat_proyek' => 'string|max:100',
            'range_min' => 'integer',
            'range_max' => 'integer',
            'keuntungan' => 'integer',
            'add_image' => 'array',
            'add_image.*' => 'mimes:jpg,jpeg,png|max:1000',
            'remove_image' => 'array',
            'remove_image.*' => 'integer',
            'update_image' => 'array',
            'update_image.*' => 'array',
            'update_image.*.id' => 'integer',
            'update_image.*.path' => 'mimes:jpg,jpeg,png|max:1000',
            'deadline' => 'date',
            'update_komponen' => 'array',
            'update_komponen.*.id' => 'integer',
            'update_komponen.*.new_data' => 'array',
            'update_komponen.*.new_data.nama_komponen' => 'string',
            'update_komponen.*.new_data.harga' => 'integer',
            'update_komponen.*.new_data.merk_type' => 'string|max:50',
            'update_komponen.*.new_data.spesifikasi_teknis' => 'string|max:80',
            'update_komponen.*.new_data.satuan' => 'string|max:20',
            'update_komponen.*.new_data.total_unit' => 'string|max:20',
            'delete_komponen' => 'array',
            'delete_komponen.*' => 'integer',
            'new_komponen' => 'array',
            'new_komponen.*.nama_komponen' => 'string',
            'new_komponen.*.harga' => 'integer',
            'new_komponen.*.merk_type' => 'string|max:50',
            'new_komponen.*.spesifikasi_teknis' => 'string|max:80',
            'new_komponen.*.satuan' => 'string|max:20',
            'new_komponen.*.total_unit' => 'string|max:20',
        ]);

        if ($validator->fails()) {
            return (new PenawaranOfflineResourceController(['error' => $validator->errors()]))->response()->setStatusCode(401);
        }

        if ($request->has('update_komponen')) {
            foreach ($request->input('update_komponen') as $item) {
                if (!KomponenPenawaranOffline::where(['id' => $item['id'], 'kode_penawaran_offline' => $id])->exists()) {
                    return (new PenawaranOfflineResourceController(['error' => 'Komponen dengan id = ' . $item["id"] . ' tidak terdapat dalam sistem.']))->response()->setStatusCode(401);
                }
            }
        }

        if ($request->has('delete_komponen')) {
            foreach ($request->input('delete_komponen') as $item) {
                if (!KomponenPenawaranOffline::where(['id' => $item, 'kode_penawaran_offline' => $id])->exists()) {
                    return (new PenawaranOfflineResourceController(['error' => 'Komponen dengan id = ' . $item . ' tidak terdapat dalam sistem.']))->response()->setStatusCode(401);
                }
            }
        }

        if ($request->has('update_image')) {
            foreach ($request->input('update_image') as $item) {
                if (!PathPhotoPenawaranOffline::where(['id' => $item['id'], 'kode_penawaran_offline' => $id])->exists()) {
                    return (new PenawaranOfflineResourceController(['error' => 'Gambar dengan id = ' . $item['id'] . ' tidak terdapat dalam sistem.']))->response()->setStatusCode(401);
                }
            }
        }

        if ($request->has('remove_image')) {
            foreach ($request->input('remove_image') as $item) {
                if (!PathPhotoPenawaranOffline::where(['id' => $item, 'kode_penawaran_offline' => $id])->exists()) {
                    return (new PenawaranOfflineResourceController(['error' => 'Gambar dengan id = ' . $item . ' tidak terdapat dalam sistem.']))->response()->setStatusCode(401);
                }
            }
        }

        try {
            $penawaran = PenawaranOffline::with('tukang')->whereHas('tukang', function ($query) {
                $query->where('id', Auth::id());
            })->where('id', $id)->firstOrFail();
//            //untuk handle rollback jika terjadi kegagalan transaksi
            DB::transaction(function () use ($request, $id, $penawaran) {
                if ($request->has('update_komponen')) {
                    foreach ($request->input('update_komponen') as $item) {
                        KomponenPenawaranOffline::where('id', $item['id'])->update($item['new_data']);
                    }
                }
                if ($request->has('delete_komponen')) {
                    KomponenPenawaranOffline::destroy($request->input('delete_komponen'));
                }
                if ($request->has('new_komponen')) {
                    foreach ($request->input('new_komponen') as $item) {
                        $komponen = new KomponenPenawaranOffline();
                        $komponen->fill($item);
                        $komponen->kode_penawaran_offline = $id;
                        $komponen->save();
                    }
                }
                $total_harga_komponen = KomponenPenawaranOffline::where('kode_penawaran_offline', $id)->sum('harga');
                $total_harga = kalkulasiBiayaPenawaranOfflineUpdate($request->input('keuntungan'), $total_harga_komponen);
                PenawaranOffline::where('id', $id)->update(['keuntungan' => $request->input('keuntungan'), 'harga_total' => $total_harga]);

                if ($request->has('add_image')) {
                    foreach ($request->file('add_image') as $file) {
                        if ($file->isValid()) {
                            $path = $file->store('images/penawaran/offline', 'public');
                            $path = substr($path, 6);
                            $path = "storage/images" . $path;

                            $mpath = new PathPhotoPenawaranOffline();
                            $mpath->kode_penawaran_offline = $id;
                            $mpath->path = $path;
                            $mpath->save();
                        }
                    }
                }

                if ($request->has('remove_image')) {
                    foreach ($request->input('remove_image') as $item) {
                        $path = PathPhotoPenawaranOffline::find($item);
                        deleteFileHelper($path->path);
                    }
                }

                if ($request->has('update_image')) {
                    $id_img = $request->input('update_image.*.id');
                    foreach ($request->file('update_image.*.path') as $key => $file) {
                        if ($file->isValid()) {
                            $path = $file->store('images/penawaran/offline', 'public');
                            $path = substr($path, 6);
                            $path = "storage/images" . $path;

                            $mpath = PathPhotoPenawaranOffline::find($id_img[$key]);
                            $mpath->path = $path;
                            $mpath->save();
                        }
                    }
                }

            });
            PenawaranOffline::where('id', $id)->update($request->except(
                [
                    'keuntungan',
                    'harga_total',
                    'add_image',
                    'remove_image',
                    'update_image',
                    'update_komponen',
                    'delete_komponen',
                    'new_komponen'
                ]));
            return (new PenawaranOfflineResourceController(['status' => true]))->response()->setStatusCode(200);
        } catch (ModelNotFoundException $ee) {
            return (new PenawaranOfflineResourceController(['error' => 'Anda tidak mempunyai akses terhadap penawaran ini !!!']))->response()->setStatusCode(401);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|object
     */
    public function destroy($id)
    {
        try {
            $penawaran = PenawaranOffline::with('tukang', 'komponen', 'path')->whereHas('tukang', function ($query) {
                $query->where('id', Auth::id());
            })->where('id', $id)->firstOrFail();

            DB::transaction(function () use ($penawaran) {
                if (isset($penawaran->komponen)) {
//                    foreach ($penawaran->komponen as $item) {
//                        $kom = KomponenPenawaranOffline::find($item);
//                        $kom->delete();
//                    }
                    $penawaran->komponen->each->delete();
                }
                if (isset($penawaran->path)) {
                    foreach ($penawaran->path as $item) {
                        $path = PathPhotoPenawaranOffline::find($item->d);
                        Storage::delete($path->path);
//                        $path->delete();
                    }
                    $penawaran->path->each->delete();
                }
                $pena = PenawaranOffline::where('id',$penawaran->id);
                $pena->delete();
            });
            return (new PenawaranOfflineResourceController(['status' => true]))->response()->setStatusCode(200);
        } catch (ModelNotFoundException $ee) {
            return (new PenawaranOfflineResourceController(['error' => 'Item tidak ditemukan !!!']))->response()->setStatusCode(401);
        }
    }
}
