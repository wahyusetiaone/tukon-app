<?php

namespace App\Http\Controllers\Tukang;

use App\Http\Controllers\Controller;
use App\Http\Resources\PenawaranResourceController;
use App\Models\Komponen;
use App\Models\Penawaran;
use App\Models\Pin;
use App\Models\Tukang;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\DataTables;

class PenawaranController extends Controller
{

    public function json(){
        $user = Auth::user()->kode_user;
        $data = Pin::with('pengajuan','pengajuan.client','pengajuan.client.user','penawaran','tukang','tukang.user')->where([['kode_tukang','=', $user],['kode_penawaran','!=', null]])->get();
        return Datatables::of($data)->addIndexColumn()
            ->addColumn('action', function($data){
                $button = '<a href="'.url('penawaran/show').'/'.$data->kode_penawaran.'"><button type="button" name="show" id="'.$data->id.'" class="edit btn btn-primary btn-sm">Show</button></a>';
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
        $tukang = Tukang::with('user')->where('id',$user)->firstOrFail();
        try {
            $data = Pin::with('pengajuan','pengajuan.client','pengajuan.client.user')->where(['id' => $id])->firstOrFail();

            return view('tukang.penawaran.add')->with(compact('data','tukang'));
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
            $data = Penawaran::create($request->except(['komponen']));
            $dump = $request->input('dump');
            Log::info($dump[0]);
            for ($i = 0; $i < sizeof($dump); $i++) {
                $komponen = new Komponen();
                $komponen->kode_penawaran = $data->id;
                $komponen->nama_komponen = (string)$dump[$i]['nama_komponen'];
                $komponen->harga = (int)$dump[$i]['harga_komponen'];
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
            $data = Pin::with('pengajuan','pengajuan.client','pengajuan.client.user','penawaran')->where(['kode_penawaran' => $id,'kode_tukang' => $user])->firstOrFail();

            return view('tukang.penawaran.show')->with(compact('data', 'tukang'));
        }catch (ModelNotFoundException $ee){
            return View('errors.404');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
