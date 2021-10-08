<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Resources\PengajuanResourceController;
use App\Models\Berkas;
use App\Models\Clients;
use App\Models\Pengajuan;
use App\Models\Pin;
use App\Models\Produk;
use DateTime;
use Facade\FlareClient\View;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
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
            $data = $tukang;
            return view('client.pengajuan.v2.form')->with(compact('id', 'multi', 'data'));
        } else {
            $multi = 0;
            $data = $tukang;
            return view('client.pengajuan.v2.form')->with(compact('id', 'multi', 'data'));
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
            'expired' => 'required',
            'path_add.*' => 'mimes:jpg,jpeg,png|max:1000',
            'path_berkas.*' => 'mimes:pdf,docx,doc|max:1000'
        ]);

        if ($id == Auth::id()) {
            $request['kode_client'] = Auth::id();
            $files = [];
            $files_berkas = [];
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
            $data = Pengajuan::create($request->except(['kode_tukang','expired']));

            //create datetime
            $date = $request->input('expired').' '.date('H:i:s');
            if ((boolean)$multi) {
                $arr = explode('_', $kode_tukang);
                foreach ($arr as $tukang) {
                    $pin = new Pin();
                    $pin->kode_pengajuan = $data->id;
                    $pin->kode_tukang = (int)$tukang;
                    $pin->status = "N01";
                    $pin->expired_at = date('Y-m-d H:i:s', strtotime($date));
                    $pin->save();
                }
            } else {
                $arr = $kode_tukang;
                $pin = new Pin();
                $pin->kode_pengajuan = $data->id;
                $pin->kode_tukang = $arr;
                $pin->status = "N01";
                $pin->expired_at = date('Y-m-d H:i:s', strtotime($date));
                $pin->save();
            }

            if ($request->has('path_berkas')){
                foreach ($request->file('path_berkas') as $file) {
                    if ($file->isValid()) {
                        $path = $file->store('berkas/pengajuan', 'public');
                        $path = substr($path, 6);
                        $path = "storage/berkas" . $path;

                        $berkas = new Berkas();
                        $berkas->kode_pengajuan = $data->id;
                        $berkas->path = $path;
                        $berkas->original_name = $file->getClientOriginalName();
                        $berkas->save();

                        $files_berkas[] = [
                            'path' => $path,
                        ];
                    }
                }
            }

            return redirect()->route('penawaran.client');
        }
        return view('errors.403');
    }

    /**
     * Display the specified resource.
     * @param int $id
     * @param \App\Models\Tukang\Pengajuan $pengajuan
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function show(int $id)
    {
        try {
            $data = Pengajuan::with('berkas','client', 'client.user', 'pin', 'pin.tukang', 'pin.tukang.user')->where(['id' => $id])->firstOrFail();

            return view('client.pengajuan.v2.show')->with(compact('data'));
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
            $data = Pengajuan::with('berkas','client', 'client.user', 'pin', 'pin.tukang', 'pin.tukang.user')->where(['id' => $id])->firstOrFail();

            return view('client.pengajuan.v2.edit')->with(compact('data'));
        } catch (ModelNotFoundException $ee) {
            return View('errors.404');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'nama_proyek' => 'required',
            'diskripsi_proyek' => 'required',
            'alamat' => 'required',
            'range_min' => 'required|integer',
            'range_max' => 'required|integer',
            'deadline' => 'required'
        ]);

        $request->request->remove('_token');
        Pengajuan::whereId($id)->update($request->all());
        Alert::success('Succesfully Updated Pengajuan', 'Update data has been saved !!!');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|object
     */
    public function destroy($id)
    {
        $has = Pengajuan::with('pin')->whereHas('pin', function ($q){
            $q->where('kode_penawaran', '!=', null);
        })->whereId($id)->exists();

        if ($has){
            $pengajuan = Pengajuan::whereId($id)->first();
            $pengajuan->update(['kode_status' => 'T04']);
            $pengajuan->save();
        }else{
            $pengajuan = Pengajuan::select('multipath','path')->find($id)->first();
            if ($pengajuan->multipath){
                $spl = explode(',', $pengajuan->path);
                foreach ($spl as $item){
                    momPleaseDeleteIt($item);
                }
            }else{
                momPleaseDeleteIt($pengajuan->path);
            }
            Pengajuan::where('id', $id)->forceDelete();
            Pin::where('kode_pengajuan', $id)->delete();
        }
        return (new PengajuanResourceController(['data' => true]))->response()->setStatusCode(200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function removeImg(Request $request, $id)
    {
        $this->validate($request, [
            'urlImg' => 'required'
        ]);

        $spl = explode('/', $request->input('urlImg'));
        $path = $spl[(count($spl) - 5)].'/'.$spl[(count($spl) - 4)] . '/' . $spl[(count($spl) - 3)] . '/' . $spl[(count($spl) - 2)] . '/' . $spl[(count($spl) - 1)];
        $pengajuan = Pengajuan::select('multipath', 'path')->whereId($id)->first();
        $data = array();
        if ($pengajuan->multipath) {
            $spl2 = explode(',', $pengajuan->path);
            if (($key = array_search($path, $spl2)) !== false) {
                unset($spl2[$key]);
            }
            $data['multipath'] = count($spl2) > 1;
            $data['path'] = implode(",", $spl2);
            Pengajuan::whereId($id)->update($data);
        } else {
            Pengajuan::whereId($id)->update(['multipath' => false, 'path' => null]);
        }
        //karena history gak di hapus file nya.
//        $namefile = $spl[(count($spl) - 1)];
//        Storage::disk('public')->delete('images/pengajuan/project' . $namefile);
        Alert::success('Succesfully Delete Photos', 'Update data has been saved !!!');
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * //     * @return \Illuminate\Http\RedirectResponse
     */
    public function addImg(Request $request, $id)
    {
        $request->validate([
            'path.*' => 'mimes:jpg,jpeg,png|max:1000'
        ]);

        $request->request->remove('_token');
        if ($request->hasfile('path_show')) {
            $files = false;
            $pengajuan = Pengajuan::select('path')->whereId($id)->first();
            $full_path = $pengajuan->path;
            foreach ($request->file('path_show') as $file) {
                if ($file->isValid()) {
                    $path = $file->store('images/pengajuan/project', 'public');
                    $path = substr($path, 6);
                    $path = "storage/images" . $path;
                    if ($full_path == "") {
                        $full_path = $path;
                    } else {
                        $full_path = $full_path . "," . $path;
                        $files = true;
                    }
                }
            }
            $request['multipath'] = $files;
            $request['path'] = $full_path;
            Pengajuan::whereId($id)->update($request->except('path_show'));
            Alert::success('Succesfully Upload Image', 'Update data has been saved !!!');
            return redirect()->back();
        }
        Alert::error('Error Upload Image', 'Update data didn`t saved !!!');
        return redirect()->back();
    }

    /**
     * Check Safety the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|object
     */
    public function checkSafetyDelete($id)
    {
        $has = Pengajuan::with('pin')->whereHas('pin', function ($q){
            $q->where('kode_penawaran', '!=', null);
        })->whereId($id)->exists();

        return (new PengajuanResourceController(['data' => $has]))->response()->setStatusCode(200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function removeBerkas(Request $request,int $id)
    {
        $this->validate($request, [
            'id' => 'required',
            'path' => 'required'
        ]);

        if(!Pengajuan::whereId($id)->exists()){
            Alert::error('Error','Pengajuan Tidak Ditemukan !');
            return redirect()->back();
        }
        if(!Berkas::whereId($request->input('id'))->exists()){
            Alert::error('Error','Berkas Tidak Ditemukan !');
            return redirect()->back();
        }
        $path = $request->input('path');

        momPleaseDeleteIt($path);

        $berkas = Berkas::find($request->input('id'));
        $berkas->delete();

        Alert::success('Success','Berkas Berhasil dihapus !');
        return redirect()->back();
    }
    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addBerkas(Request $request,int $id)
    {
        $this->validate($request, [
            'berkas' => 'required',
        ]);

        if(!Pengajuan::whereId($id)->exists()){
            Alert::error('Error','Pengajuan Tidak Ditemukan !');
            return redirect()->back();
        }

        foreach ($request->file('berkas') as $file) {
            if ($file->isValid()) {
                $path = $file->store('berkas/pengajuan', 'public');
                $path = substr($path, 6);
                $path = "storage/berkas" . $path;

                $berkas = new Berkas();
                $berkas->kode_pengajuan = $id;
                $berkas->path = $path;
                $berkas->original_name = $file->getClientOriginalName();
                $berkas->save();

                $files_berkas[] = [
                    'path' => $path,
                ];
            }
        }

        Alert::success('Success','Berkas berhasil ditambahkan !');
        return redirect()->back();
    }
}
