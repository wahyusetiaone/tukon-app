<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\PenawaranResourceController;
use App\Models\BPA;
use App\Models\History_Penawaran;
use App\Models\Komponen;
use App\Models\Penawaran;
use App\Models\Pin;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\Console\Input\Input;

class PenawaranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|object
     */
    public function index(Request $request)
    {
        $id = Auth::id();
        try {
            if($request->input('only') == 'batal'){
                $data = Penawaran::with('bpa', 'komponen', 'pin','pin.revisi','pin.pembayaran', 'pin.pengajuan', 'pin.pengajuan.client', 'pin.pengajuan.client.user')->whereHas('pin', function ($query) use ($id) {
                    $query->where([['kode_tukang', $id],['status', 'B01']])
                        ->orWhere([['kode_tukang', $id],['status', 'B02']])
                        ->orWhere([['kode_tukang', $id],['status', 'B04']]);
                })->paginate(10);
            }elseif($request->input('only') == 'menunggu-pembayaran'){
                $data = Penawaran::with('bpa', 'komponen', 'pin','pin.revisi','pin.pembayaran', 'pin.pengajuan', 'pin.pengajuan.client', 'pin.pengajuan.client.user')->whereHas('pin', function ($query) use ($id) {
                    $query->where([['kode_tukang', $id],['status', 'D02']]);
                })->paginate(10);
            }else{
                $data = Penawaran::with('bpa', 'komponen', 'pin','pin.revisi','pin.pembayaran', 'pin.pengajuan', 'pin.pengajuan.client', 'pin.pengajuan.client.user')->whereHas('pin', function ($query) use ($id) {
                    $query->where([['kode_tukang', $id],['status', 'N01']]);
                    $query->orWhere([['kode_tukang', $id],['status', 'D01A']]);
                    $query->orWhere([['kode_tukang', $id],['status', 'D01B']]);
                })->paginate(10);
            }
            return (new PenawaranResourceController($data))->response()->setStatusCode(200);
        } catch (ModelNotFoundException $e) {
            return (new PenawaranResourceController(['error' => 'Item penawaran tidak ditemukan.']))->response()->setStatusCode(401);
        }
    }

    /**
     * Show the form for creating a new resource.
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|object
     */
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kode_pin' => 'required|integer',
            'keuntungan' => 'required',
            'kode_bpa' => 'required|integer',
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
        ]);

        if ($validator->fails()) {
            return (new PenawaranResourceController(['error' => $validator->errors()]))->response()->setStatusCode(401);
        }

        if (sizeof($request->input('nama_komponen')) !== sizeof($request->input('harga_komponen'))) {
            return (new PenawaranResourceController(['error' => 'nama_komponen not same length with harga_komponen !']))->response()->setStatusCode(401);
        }
        $id = User::with('tukang')->find(Auth::id())->kode_user;
        $request['kode_status'] = 'T02';
        try {
            Pin::where(['id' => $request->input('kode_pin'), 'kode_tukang' => $id])->firstOrFail();
            $nama = $request->input('nama_komponen');
            $harga = $request->input('harga_komponen');
            $merk_type_komponen = $request->input('merk_type_komponen');
            $spesifikasi_komponen = $request->input('spesifikasi_komponen');
            $satuan_komponen = $request->input('satuan_komponen');
            $total_unit_komponen = $request->input('total_unit_komponen');
            $bpa = BPA::orderBy('created_at', 'DESC')->firstOrFail();
            $tt_harga = kalkulasiBiayaPenawaranBaru($request->input('keuntungan'), $bpa->bpa, $harga, $total_unit_komponen);
            $request['harga_total'] = $tt_harga;
            $data = Penawaran::create($request->except(['nama_komponen', 'harga_komponen', 'merk_type_komponen', 'spesifikasi_komponen', 'satuan_komponen', 'total_unit_komponen']));

            $dump = null;
            for ($i = 0; $i < sizeof($nama); $i++) {
                $komponen = new Komponen();
                $komponen->kode_penawaran = $data->id;
                $komponen->nama_komponen = $nama[$i];
                $komponen->harga = $harga[$i];
                $komponen->merk_type = $merk_type_komponen[$i];
                $komponen->spesifikasi_teknis = $spesifikasi_komponen[$i];
                $komponen->satuan = $satuan_komponen[$i];
                $komponen->total_unit = $total_unit_komponen[$i];
                $komponen->save();
                $dump[$i] = $komponen;
            }
            $data['komponen'] = $dump;
            $data['kode_pin'] = $request->input('kode_pin');
            Pin::where(['id' => $request->input('kode_pin'), 'kode_tukang' => $id])->update(['kode_penawaran' => $data->id]);
            return (new PenawaranResourceController($data))->response()->setStatusCode(200);
        } catch (ModelNotFoundException $e) {
            return (new PenawaranResourceController(['error' => $e->getMessage()]))->response()->setStatusCode(401);
        }
        return (new PenawaranResourceController(['error' => 'Unauthorised']))->response()->setStatusCode(401);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|object
     */
    public function show($id)
    {

        if (!Penawaran::whereId($id)->exists()){
            return (new PenawaranResourceController(['error' => 'Item penawaran tidak ditemukan.']))->response()->setStatusCode(401);
        }

        try {
            $data = Penawaran::with('bpa', 'komponen', 'pin','pin.revisi','pin.pembayaran', 'pin.pengajuan', 'pin.pengajuan.client', 'pin.pengajuan.client.user')->where('id', $id)->get();
            if (Auth::id() != $data[0]->pin->kode_tukang) {
                return (new PenawaranResourceController(['error' => 'Anda tidak mempunyai akses atas item penawaran ini !']))->response()->setStatusCode(401);
            }
            return (new PenawaranResourceController($data))->response()->setStatusCode(200);
        } catch (ModelNotFoundException $e) {
            return (new PenawaranResourceController(['error' => 'Item penawaran tidak ditemukan.']))->response()->setStatusCode(401);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|object
     */
    public function showclient($id)
    {
        try {
            $data = Penawaran::with('pin', 'komponen', 'pin.tukang.user', 'pin.pengajuan', 'pin.pengajuan.client', 'pin.pengajuan.client.user', 'pin.revisi')->where('id', $id)->firstOrFail();
            if (Auth::id() != $data->pin->pengajuan->kode_client) {
                return (new PenawaranResourceController(['error' => 'Anda tidak mempunyai akses atas item penawaran ini !']))->response()->setStatusCode(401);
            }
            return (new PenawaranResourceController($data))->response()->setStatusCode(200);
        } catch (ModelNotFoundException $e) {
            return (new PenawaranResourceController(['error' => 'Item penawaran tidak ditemukan.']))->response()->setStatusCode(401);
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
            return (new PenawaranResourceController(['error' => 'mush have one input.']))->response()->setStatusCode(401);
        }

        $validator = Validator::make($request->all(), [
            'keuntungan' => 'integer',
            'harga_total' => 'integer'
        ]);

        if ($validator->fails()) {
            return (new PenawaranResourceController(['error' => $validator->errors()]))->response()->setStatusCode(401);
        }

        $kode_user = User::with('tukang')->find(Auth::id())->kode_user;
        $request['kode_tukang'] = $kode_user;
        $request['kode_status'] = 'S02';
        try {
            Pin::where(['kode_penawaran' => $id, 'kode_tukang' => $kode_user])->firstOrFail();
            $data = Penawaran::findOrFail($id);
            $data->update($request->except(['kode_client']));
            return (new PenawaranResourceController($request))->response()->setStatusCode(200);
        } catch (ModelNotFoundException $e) {
            return (new PenawaranResourceController(['error' => $e->getMessage()]))->response()->setStatusCode(401);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|object
     */
    public function updatev2(Request $request, $id)
    {
        if (!count($request->all())) {
            return (new PenawaranResourceController(['error' => 'mush have one input.']))->response()->setStatusCode(401);
        }

        $validator = Validator::make($request->all(), [
            'keuntungan' => 'integer|max:100',
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
            return (new PenawaranResourceController(['error' => $validator->errors()]))->response()->setStatusCode(401);
        }

        if ($request->has('update_komponen')) {
            foreach ($request->input('update_komponen') as $item) {
                if (!Komponen::where(['id' => $item['id'], 'kode_penawaran' => $id])->exists()) {
                    return (new PenawaranResourceController(['error' => 'Komponen dengan id = ' . $item["id"] . ' tidak terdapat dalam sistem.']))->response()->setStatusCode(401);
                }
            }
        }

        if ($request->has('delete_komponen')) {
            foreach ($request->input('delete_komponen') as $item) {
                if (!Komponen::where(['id' => $item, 'kode_penawaran' => $id])->exists()) {
                    return (new PenawaranResourceController(['error' => 'Komponen dengan id = ' . $item . ' tidak terdapat dalam sistem.']))->response()->setStatusCode(401);
                }
            }
        }

        try {
            $penawaran = Penawaran::with('pin', 'bpa')->whereHas('pin', function ($query) {
                $query->where('kode_tukang', Auth::id());
            })->where('id', $id)->firstOrFail();
            //untuk handle rollback jika terjadi kegagalan transaksi
            DB::transaction(function () use ($request, $id, $penawaran) {
                if ($request->has('update_komponen')) {
                    foreach ($request->input('update_komponen') as $item) {
                        Komponen::where('id', $item['id'])->update($item['new_data']);
                    }
                }
                if ($request->has('delete_komponen')) {
                    Komponen::destroy($request->input('delete_komponen'));
                }
                if ($request->has('new_komponen')) {

                    foreach ($request->input('new_komponen') as $item) {
                        $komponen = new Komponen();
                        $komponen->fill($item);
                        $komponen->kode_penawaran = $id;
                        $komponen->save();
                    }
                }
                $total_harga_komponen = Komponen::where('kode_penawaran', $id)->sum('harga');
                $total_harga = kalkulasiBiayaPenawaranUpdate($request->input('keuntungan'), $penawaran->bpa->bpa, $total_harga_komponen);
                Penawaran::where('id', $id)->update(['kode_status' => 'T02', 'keuntungan' => $request->input('keuntungan'), 'harga_total' => $total_harga]);
            });

            return (new PenawaranResourceController(['status' => true]))->response()->setStatusCode(200);
        } catch (ModelNotFoundException $ee) {
            return (new PenawaranResourceController(['error' => 'Anda tidak mempunyai akses terhadap penawaran ini !!!']))->response()->setStatusCode(200);
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
            $data = Penawaran::findOrFail($id)->delete();

        } catch (ModelNotFoundException $e) {
            $data['status'] = 'error';
            $data['message'] = $e->getMessage();
        }
        return (new PenawaranResourceController(['id' => $id, 'status' => $data]))->response()->setStatusCode(200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|object
     */
    public function destroy_komponen($id)
    {
        $kode_user = User::with('tukang')->find(Auth::id())->kode_user;
        try {
            $komponen = Komponen::with('penawaran', 'penawaran.pin')->findOrFail($id);
            $read_kode_tukang = $komponen->penawaran->pin->kode_tukang;
            if ($read_kode_tukang == $kode_user) {
                $data = Komponen::findOrFail($id)->delete();
                $komponen['status'] = $data;
                return (new PenawaranResourceController($komponen))->response()->setStatusCode(200);
            } else {
                return (new PenawaranResourceController(['error' => 'you not have permission to modif this record !']))->response()->setStatusCode(401);
            }
        } catch (ModelNotFoundException $e) {
            return (new PenawaranResourceController(['error' => $e->getMessage()]))->response()->setStatusCode(401);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|object
     */
    public function update_komponen(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama_komponen' => 'required|string',
            'harga_komponen' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return (new PenawaranResourceController(['error' => $validator->errors()]))->response()->setStatusCode(401);
        }

        $kode_user = User::with('tukang')->find(Auth::id())->kode_user;
        try {
            $komponen = Komponen::with('penawaran', 'penawaran.pin')->findOrFail($id);
            $read_kode_tukang = $komponen->penawaran->pin->kode_tukang;
            if ($read_kode_tukang == $kode_user) {
                $komponen['harga'] = $request->input('harga_komponen');
                $stat = $komponen->update($request->except('harga_komponen'));
                $komponen['status'] = $stat;
                return (new PenawaranResourceController($komponen))->response()->setStatusCode(200);
            } else {
                return (new PenawaranResourceController(['error' => 'you not have permission to modif this record !']))->response()->setStatusCode(401);
            }
        } catch (ModelNotFoundException $e) {
            return (new PenawaranResourceController(['error' => $e->getMessage()]))->response()->setStatusCode(401);
        }
    }
}
