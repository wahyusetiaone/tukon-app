<?php

namespace App\Http\Controllers\Tukang;

use App\Http\Controllers\Controller;
use App\Http\Resources\PengajuanResourceController;
use App\Models\Pin;
use App\Models\Tukang;
use App\Models\Tukang\Pengajuan;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class PengajuanController extends Controller
{

    public function json(){
        $user = Auth::user()->kode_user;
        $data = Pin::with('pengajuan','pengajuan.client','pengajuan.client.user')->where('kode_tukang', $user)->get();
        return Datatables::of($data)->addIndexColumn()
            ->addColumn('action', function($data){
                $button = '<a href="'.url('pengajuan/show').'/'.$data->id.'"><button type="button" name="show" id="'.$data->id.'" class="edit btn btn-primary btn-sm">Show</button></a>';
                return $button;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('tukang.pengajuan.all');
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     * @param int $id
     * @param  \App\Models\Tukang\Pengajuan  $pengajuan
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function show(Pengajuan $pengajuan, int $id)
    {
        $user = Auth::user()->kode_user;
        $tukang = Tukang::with('user')->where('id',$user)->firstOrFail();
        try {
            $data = Pin::with('pengajuan','pengajuan.client','pengajuan.client.user')->where(['id' => $id,'kode_tukang' => $user])->firstOrFail();

            return view('tukang.pengajuan.show')->with(compact('data', 'tukang'));
        }catch (ModelNotFoundException $ee){
            return View('errors.404');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tukang\Pengajuan  $pengajuan
     * @return \Illuminate\Http\Response
     */
    public function edit(Pengajuan $pengajuan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tukang\Pengajuan  $pengajuan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pengajuan $pengajuan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tukang\Pengajuan  $pengajuan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pengajuan $pengajuan)
    {
        //
    }

    /**
     * Tolak pengajuan base on PIN the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|object
     */

    public function tolak_pengajuan(int $id)
    {
        $kode_user = User::with('tukang')->find(Auth::id())->kode_user;
        try {
            $old = Pin::where(['id' => $id, 'kode_tukang' => $kode_user])->firstOrFail();
            $old->update(['status' => 'T03']);

            return (new PengajuanResourceController(['update_status' => $old]))->response()->setStatusCode(200);
        } catch (ModelNotFoundException $e) {
            return (new PengajuanResourceController(['error' => $e->getMessage()]))->response()->setStatusCode(401);
        }
    }
}
