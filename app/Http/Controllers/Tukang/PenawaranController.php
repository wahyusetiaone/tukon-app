<?php

namespace App\Http\Controllers\Tukang;

use App\Http\Controllers\Controller;
use App\Http\Resources\PenawaranResourceController;
use App\Models\BPA;
use App\Models\Komponen;
use App\Models\Penawaran;
use App\Models\Pin;
use App\Models\Sistem_Penarikan_Dana;
use App\Models\Tukang;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;

class PenawaranController extends Controller
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
        return view('tukang.penawaran.all');
    }

    /**
     * Show the form for creating a new resource.
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create(int $id)
    {
        $user = Auth::user()->kode_user;
        $bpa = BPA::first();
        $spd = Sistem_Penarikan_Dana::all();

        $tukang = Tukang::with('user')->where('id',$user)->firstOrFail();
        try {
            $data = Pin::with('pengajuan','pengajuan.client','pengajuan.client.user')->where(['id' => $id])->firstOrFail();

            return view('tukang.penawaran.add')->with(compact('data','tukang', 'bpa', 'spd'));
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
            $data = Penawaran::create($request->except(['komponen']));
            $dump = $request->input('dump');
            Log::info($dump[0]);
            for ($i = 0; $i < sizeof($dump); $i++) {
                $komponen = new Komponen();
                $komponen->kode_penawaran = $data->id;
                $komponen->nama_komponen = (string)$dump[$i]['nama_komponen'];
                $komponen->harga = (int)$dump[$i]['harga_komponen'];
                $komponen->merk_type = (string)$dump[$i]['merk_type'];
                $komponen->spesifikasi_teknis = (string)$dump[$i]['spesifikasi_teknis'];
                $komponen->satuan = (string)$dump[$i]['satuan'];
                $komponen->total_unit = (int)$dump[$i]['total_unit'];
                $komponen->save();
            }
            Pin::where(['id' => $request->input('kode_pin')])->update(['kode_penawaran' => $data->id]);
            $dump['kode_penawaran'] = $data->id;
            return (new PenawaranResourceController($dump))->response()->setStatusCode(200);
        } catch (ModelNotFoundException $e) {
            return (new PenawaranResourceController(['error' => $e->getMessage()]))->response()->setStatusCode(401);
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
            $data = Pin::with('revisi','pengajuan','pengajuan.client','pengajuan.client.user','penawaran','penawaran.komponen','pembayaran')->where(['kode_penawaran' => $id,'kode_tukang' => $user])->firstOrFail();

            return view('tukang.penawaran.show')->with(compact('data', 'tukang'));
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
        $bpa = BPA::first();
        $spd = Sistem_Penarikan_Dana::all();
        try {
            $tukang = Tukang::with('user')->where('id',$user)->firstOrFail();
            $data = Pin::with('revisi','pengajuan','pengajuan.client','pengajuan.client.user','penawaran','penawaran.komponen')->where(['kode_penawaran' => $id,'kode_tukang' => $user])->firstOrFail();
            $old_bpa = BPA::where('id', $data->penawaran->kode_bpa)->first();

            return view('tukang.penawaran.edit')->with(compact('spd','data', 'tukang','bpa', 'old_bpa'));
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
        $request['kode_status'] = 'T02';
        try {
            $data = Penawaran::findOrFail($id);
            $data->update($request->except(['dump_add','dump_remove']));
            $dump = $request->input('dump_add');
            if (isset($dump)){
                for ($i = 0; $i < sizeof($dump); $i++) {
                    $komponen = new Komponen();
                    $komponen->kode_penawaran = $data->id;
                    $komponen->nama_komponen = (string)$dump[$i]['nama_komponen'];
                    $komponen->harga = (int)$dump[$i]['harga_komponen'];
                    $komponen->merk_type = (string)$dump[$i]['merk_type'];
                    $komponen->spesifikasi_teknis = (string)$dump[$i]['spesifikasi_teknis'];
                    $komponen->satuan = (string)$dump[$i]['satuan'];
                    $komponen->total_unit = (int)$dump[$i]['total_unit'];
                    $komponen->save();
                }
            }
            $dump = $request->input('dump_remove');
            if (isset($dump)){
                for ($i = 0; $i < sizeof($dump); $i++) {
                    $komponen = Komponen::find((int)$dump[$i]['id']);
                    $komponen->delete();
                }
            }
            return (new PenawaranResourceController(['status' => $data]))->response()->setStatusCode(200);
        } catch (ModelNotFoundException $e) {
            return (new PenawaranResourceController(['error' => $e]))->response()->setStatusCode(401);
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
