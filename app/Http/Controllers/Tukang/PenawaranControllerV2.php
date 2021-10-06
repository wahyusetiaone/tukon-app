<?php

namespace App\Http\Controllers\Tukang;

use App\Http\Controllers\Controller;
use App\Http\Resources\PenawaranResourceController;
use App\Models\BACabang;
use App\Models\BPA;
use App\Models\Komponen;
use App\Models\NegoPenawaran;
use App\Models\Penawaran;
use App\Models\Pin;
use App\Models\Sistem_Penarikan_Dana;
use App\Models\Tukang;
use App\Models\User;
use App\Observers\NegoPenawaranObserver;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use RealRashid\SweetAlert\Facades\Alert;
use stdClass;
use Yajra\DataTables\DataTables;

class PenawaranControllerV2 extends Controller
{

    public function json(){
        $user = Auth::user()->kode_user;
        $data = Pin::with('pengajuan','pengajuan.client','pengajuan.client.user','penawaran','tukang','tukang.user')->where([['kode_tukang','=', $user],['kode_penawaran','!=', null]])->get();
        return Datatables::of($data)->addIndexColumn()
            ->addColumn('action', function($data){
                if ($data->pengajuan->deleted_at == null) {
                    $button = '<a href="' . url('penawaran/show') . '/' . $data->kode_penawaran . '"><button type="button" name="show" id="' . $data->id . '" class="edit btn btn-primary btn-sm pl-4 pr-4">Lihat</button></a>';
                }else{
                    $button = '<a href="' . url('penawaran/show') . '/' . $data->kode_penawaran . '"><button type="button" name="show" id="' . $data->id . '" class="edit btn btn-danger btn-sm pl-4 pr-4" disabled>Hapus</button></a>';
                }
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
        return view('tukang.penawaran.v2.all');
    }

    /**
     * Show the form for creating a new resource.
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create(int $id)
    {
        $user = Auth::user()->kode_user;

        $spd = Sistem_Penarikan_Dana::all();

        $tukang = Tukang::with('user')->where('id',$user)->firstOrFail();

        if ($tukang->verifikasi_lokasi){
            //BPA memuat 2 item
            $base_bpa = BPA::first();
            $base_bac = BACabang::first();
            $bpa = new stdClass;

            $bpa->bpa = $base_bpa->bpa + $base_bac->bac;
        }else{
            $bpa = BPA::first();
        }

        try {
            $data = Pin::with('pengajuan','pengajuan.client','pengajuan.client.user')->where(['id' => $id])->firstOrFail();

            return view('tukang.penawaran.v2.add')->with(compact('data','tukang', 'bpa', 'spd'));
        }catch (ModelNotFoundException $ee){
            return View('error.404');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|object
     */
    public function store(Request $request)
    {
        $request['kode_status'] = 'T02';
        try {
            Pin::where(['id' => $request->input('kode_pin')])->firstOrFail();
            $request['kode_bpa'] = BPA::select('id')->orderBy('created_at','desc')->first()->id;
            $request['kode_bac'] = BACabang::select('id')->orderBy('created_at','desc')->first()->id;
            $data = Penawaran::create($request->all());
            Pin::where(['id' => $request->input('kode_pin')])->update(['kode_penawaran' => $data->id]);

            Alert::success('Succesfully Saved', 'Berhasil melakukan penawaran!');
            return redirect()->route('show.penawaran', $data->id);
        } catch (ModelNotFoundException $e) {
            Alert::success('Error', 'Gagal melakukan Penawaran!');
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = Auth::user()->kode_user;
        try {
            $tukang = Tukang::with('user')->where('id',$user)->firstOrFail();
            $data = Pin::with('revisi','pengajuan','pengajuan.client','pengajuan.client.user','penawaran.nego','pembayaran')->where(['kode_penawaran' => $id,'kode_tukang' => $user])->firstOrFail();

            return view('tukang.penawaran.v2.show')->with(compact('data', 'tukang'));
        }catch (ModelNotFoundException $ee){
            return View('errors.404');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = Auth::user()->kode_user;

        $tukang = Tukang::with('user')->where('id',$user)->firstOrFail();

        if ($tukang->verifikasi_lokasi){
            //BPA memuat 2 item
            $base_bpa = BPA::first();
            $base_bac = BACabang::first();
            $bpa = new stdClass;

            $bpa->bpa = $base_bpa->bpa + $base_bac->bac;
        }else{
            $bpa = BPA::first();
        }

        $spd = Sistem_Penarikan_Dana::all();
        try {
            $data = Pin::with('revisi','pengajuan','pengajuan.client','pengajuan.client.user','penawaran','penawaran.komponen')->where(['kode_penawaran' => $id,'kode_tukang' => $user])->firstOrFail();

            if ($tukang->verifikasi_lokasi){
                //old juga memuat 2 item
                $base_old_bpa = BPA::where('id', $data->penawaran->kode_bpa)->first();
                $base_old_bac = BACabang::where('id', $data->penawaran->kode_bac)->first();
                $old_bpa = new stdClass;
                $old_bpa->bpa = $base_old_bpa->bpa + $base_old_bac->bac;
            }else{
                $old_bpa = BPA::where('id', $data->penawaran->kode_bpa)->first();
            }

            return view('tukang.penawaran.v2.edit')->with(compact('spd','data', 'tukang','bpa', 'old_bpa'));
        }catch (ModelNotFoundException $ee){
            return view('errors.404');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|object
     */
    public function update(Request $request, $id)
    {
        $request['kode_bpa'] = BPA::select('id')->orderBy('created_at','desc')->first()->id;
        $request['kode_bac'] = BACabang::select('id')->orderBy('created_at','desc')->first()->id;
        $request['kode_status'] = 'T02';
        try {
            $data = Penawaran::findOrFail($id);
            $data->update($request->all());
            Alert::success('Succesfully Saved', 'Berhasil mengupload ulang penawaran!');
            return redirect()->route('show.penawaran', $data->id);
        } catch (ModelNotFoundException $e) {
            Alert::success('Error', 'Gagal melakukan Penawaran!');
            return redirect()->back();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|object
     */
    public function tolak_nego(Request $request, $id)
    {
        if (!Penawaran::whereId($id)->exists()){
            Alert::success('Error', 'Penawaran tidak ditemukan!');
            return redirect()->back();
        }

        try {
            $data = NegoPenawaran::whereId($request->input('nego_id'))->first();
            $data->disetujui = false;
            $data->save();
            Alert::success('Succesfully Updated', 'Berhasil menolak harga Nego Penawaran!');
            return redirect()->back();
        } catch (ModelNotFoundException $e) {
            Alert::success('Error', 'Gagal menolak harga Nego Penawaran!');
            return redirect()->back();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|object
     */
    public function setuju_nego(Request $request, $id)
    {
        if (!Penawaran::whereId($id)->exists()){
            Alert::success('Error', 'Penawaran tidak ditemukan!');
            return redirect()->back();
        }
        try {
            $data = NegoPenawaran::whereId($request->input('nego_id'))->first();
            $data->disetujui = true;
            $data->save();
            Alert::success('Succesfully Updated', 'Berhasil menyetujui harga Nego Penawaran!');
            return redirect()->back();
        } catch (ModelNotFoundException $e) {
            Alert::success('Error', 'Gagal menyetujui harga Nego Penawaran!');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
