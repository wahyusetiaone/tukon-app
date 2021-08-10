<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Resources\PengajuanResourceController;
use App\Models\Clients;
use App\Models\Pengajuan;
use App\Models\Pin;
use App\Models\Produk;
use Facade\FlareClient\View;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class PengajuanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        $data = Pengajuan::where('kode_client', Auth::id())->paginate(5)->toArray();
        return view('client.pengajuan.all')->with(compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     * @param String $tukang
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create(string $tukang)
    {
        $id = Auth::id();
        $multi = null;
        $data = null;
        if (strpos($tukang, '_') !== false) {
            $multi = 1;
            $data = explode('_', $tukang);
            return view('client.pengajuan.form')->with(compact('id', 'multi', 'data'));
        } else {
            $multi = 0;
            $data = $tukang;
            return view('client.pengajuan.form')->with(compact('id', 'multi', 'data'));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param int $id
     * @param int $multi
     * @param String $kode_tukang
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, int $id, int $multi, string $kode_tukang)
    {
        $this->validate($request, [
            'nama_proyek' => 'required',
            'diskripsi_proyek' => 'required',
            'alamat' => 'required',
            'deadline' => 'required',
            'path_add' => 'required',
            'range_min' => 'required',
            'range_max' => 'required',
            'path_add.*' => 'mimes:jpg,jpeg,png|max:1000'
        ]);

        if ($id == Auth::id()) {
            $request['kode_client'] = Auth::id();
            $files = [];
            $full_path = "";
            foreach ($request->file('path_add') as $file) {
                if ($file->isValid()) {
                    $path = $file->store('images/pengajuan/project', 'public');
                    $path = substr($path, 6);
                    $path = "storage/images" . $path;
                    if ($full_path == "") {
                        $full_path = $path;
                    } else {
                        $full_path = $full_path . "," . $path;
                    }
                    $files[] = [
                        'path' => $path,
                    ];
                }
            }
            $request['multipath'] = sizeof($files) > 1;
            $request['path'] = $full_path;
            $request['offline'] = false;
            $request['kode_status'] = 'T01';
            $data = Pengajuan::create($request->except(['kode_tukang']));
            if ((boolean)$multi) {
                $arr = explode('_', $kode_tukang);
                foreach ($arr as $tukang) {
                    $pin = new Pin();
                    $pin->kode_pengajuan = $data->id;
                    $pin->kode_tukang = (int)$tukang;
                    $pin->status = "N01";
                    $pin->save();
                }
            } else {
                $arr = $kode_tukang;
                $pin = new Pin();
                $pin->kode_pengajuan = $data->id;
                $pin->kode_tukang = $arr;
                $pin->status = "N01";
                $pin->save();
            }
            return redirect()->route('pengajuan.client');
        }
        return view('errors.403');
    }

    /**
     * Display the specified resource.
     * @param int $id
     * @param  \App\Models\Tukang\Pengajuan  $pengajuan
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function show(int $id)
    {
        try {
            $data = Pengajuan::with('client','client.user','pin','pin.tukang','pin.tukang.user')->where(['id' => $id])->firstOrFail();

            return view('client.pengajuan.show')->with(compact('data'));
        }catch (ModelNotFoundException $ee){
            return View('errors.404');
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
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
