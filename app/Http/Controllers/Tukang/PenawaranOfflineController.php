<?php

namespace App\Http\Controllers\Tukang;

use App\Http\Controllers\Controller;
use App\Http\Resources\PenawaranOfflineResourceController;
use App\Models\KomponenPenawaranOffline;
use App\Models\PathPhotoPenawaranOffline;
use App\Models\PenawaranOffline;
use App\Models\Tukang;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;

class PenawaranOfflineController extends Controller
{

    public function json()
    {
        $data = PenawaranOffline::with('komponen', 'path')->where('kode_tukang', Auth::id())->get();
        return Datatables::of($data)->addIndexColumn()
            ->addColumn('action', function ($data) {
                $button = '<a href="' . url('penawaran-offline/show') . '/' . $data->id . '"><button type="button" name="show" id="' . $data->id . '" class="edit btn btn-primary btn-sm pl-4 pr-4">Lihat</button></a>';
                return $button;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        return view('tukang.penawaran_offline.all');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        return view('tukang.penawaran_offline.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_client' => 'required',
            'email_client' => 'required|email',
            'nomor_telepon_client' => 'required',
            'kota_client' => 'required',
            'alamat_client' => 'required',
            'nama_proyek' => 'required',
            'alamat_proyek' => 'required',
            'deadline' => 'required|date|after:now',
            'diskripsi_proyek' => 'required',
            'image' => 'required|array',
            'image.*' => 'mimes:jpg,jpeg,png|max:1000',
            'nama_komponen' => 'required|array',
            'nama_komponen.*' => 'required|string',
            'harga_komponen' => 'required|array',
            'harga_komponen.*' => 'required|integer',
            'merk_type_komponen' => 'required|array',
            'merk_type_komponen.*' => 'required|string',
            'spesifikasi_komponen' => 'required|array',
            'spesifikasi_komponen.*' => 'required|string',
            'satuan' => 'required|array',
            'satuan.*' => 'required|string',
            'total_unit' => 'required|array',
            'total_unit.*' => 'required|string',
        ]);

        $request['kode_tukang'] = Auth::id();

        DB::transaction(function () use ($request, &$data) {
            $data = PenawaranOffline::create($request->except(['image', 'nama_komponen', 'harga_komponen', 'merk_type_komponen', 'spesifikasi_komponen', 'satuan', 'total_unit']));

            $namakomponen = $request->input('nama_komponen');
            $harga_komponen = $request->input('harga_komponen');
            $merk_type_komponen = $request->input('merk_type_komponen');
            $spesifikasi_komponen = $request->input('spesifikasi_komponen');
            $satuan = $request->input('satuan');
            $total_unit = $request->input('total_unit');

            for ($i = 0; $i < sizeof($namakomponen); $i++) {
                $komponen = new KomponenPenawaranOffline();
                $komponen->kode_penawaran_offline = $data->id;
                $komponen->nama_komponen = $namakomponen[$i];
                $komponen->harga = $harga_komponen[$i];
                $komponen->merk_type = $merk_type_komponen[$i];
                $komponen->spesifikasi_teknis = $spesifikasi_komponen[$i];
                $komponen->satuan = $satuan[$i];
                $komponen->total_unit = $total_unit[$i];
                $komponen->save();
            }

            foreach ($request->file('image') as $file) {
                if ($file->isValid()) {
                    $path = $file->store('images/produk', 'public');
                    $path = substr($path, 6);
                    $path = "storage/images" . $path;
                    $offpath = new PathPhotoPenawaranOffline();
                    $offpath->kode_penawaran_offline = $data->id;
                    $offpath->path = $path;
                    $offpath->save();
                }
            }

        });

        Alert::success('Status Perubahan', 'Berhasil membuat penawaran baru.');
        return redirect()->route('data.penawaran.offline.show', $data->id);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $data = PenawaranOffline::with('tukang', 'tukang.user', 'komponen', 'path')->where('kode_tukang', Auth::id())->where('id', $id)->firstOrFail();
            return view('tukang.penawaran_offline.show')->with(compact('data'));
        } catch (ModelNotFoundException $ee) {
            return View('errors.404');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $data = PenawaranOffline::with('tukang', 'tukang.user', 'komponen', 'path')->where('kode_tukang', Auth::id())->where('id', $id)->firstOrFail();
            return view('tukang.penawaran_offline.edit')->with(compact('data'));
        } catch (ModelNotFoundException $ee) {
            return View('errors.404');
        }
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
        try {
            $data = PenawaranOffline::find($id);
            $data->update($request->except(['dump_add', 'dump_remove']));
            $dump = $request->input('dump_add');
            if (isset($dump)) {
                for ($i = 0; $i < sizeof($dump); $i++) {
                    $komponen = new KomponenPenawaranOffline();
                    $komponen->kode_penawaran_offline = $data->id;
                    $komponen->nama_komponen = (string)$dump[$i]['nama_komponen'];
                    $komponen->harga = (int)$dump[$i]['harga_komponen'];
                    $komponen->merk_type = (string)$dump[$i]['merk_type_komponen'];
                    $komponen->spesifikasi_teknis = (string)$dump[$i]['spesifikasi_teknis_komponen'];
                    $komponen->satuan = (string)$dump[$i]['satuan_komponen'];
                    $komponen->total_unit = (int)$dump[$i]['total_unit_komponen'];
                    $komponen->save();
                }
            }
            $dump = $request->input('dump_remove');
            if (isset($dump)) {
                for ($i = 0; $i < sizeof($dump); $i++) {
                    $komponen = KomponenPenawaranOffline::find((int)$dump[$i]['id']);
                    $komponen->delete();
                }
            }
            return (new PenawaranOfflineResourceController(['status' => $data]))->response()->setStatusCode(200);
        } catch (ModelNotFoundException $e) {
            return (new PenawaranOfflineResourceController(['error' => $e->getMessage()]))->response()->setStatusCode(401);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update_client(Request $request, $id)
    {
        $request->validate([
            'nama_client' => 'required',
            'email_client' => 'required|email',
            'nomor_telepon_client' => 'required',
            'kota_client' => 'required',
            'alamat_client' => 'required',
        ]);

        DB::transaction(function () use ($id, $request) {
            PenawaranOffline::find($id)->update($request->all());
        });

        Alert::success('Status Perubahan', 'Berhasil menyimpan perubahan informasi klien.');
        return redirect()->route('data.penawaran.offline.show', $id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update_proyek(Request $request, $id)
    {
        $request->validate([
            'nama_proyek' => 'required',
            'alamat_proyek' => 'required',
            'deadline' => 'required|date|after:now',
            'diskripsi_proyek' => 'required'
        ]);

        DB::transaction(function () use ($id, $request) {
            PenawaranOffline::find($id)->update($request->all());
        });

        Alert::success('Status Perubahan', 'Berhasil menyimpan perubahan informasi proyek.');
        return redirect()->route('data.penawaran.offline.show', $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
