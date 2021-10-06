<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Penawaran;
use App\Models\Pengajuan;
use App\Models\Pin;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PenawaranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->input('only') == 'batal'){
            $data = Pengajuan::with('pin', 'pin.penawaran', 'pin.tukang','pin.tukang.user')->where('kode_client',Auth::id())
                ->whereHas('pin', function ($q){
                    $q->where('status', 'B01')
                        ->orWhere('status', 'B02')
                        ->orWhere('status', 'B04');
                })
                ->orderByDesc('created_at')
                ->paginate(5)->toArray();
        }else{
            $data = Pengajuan::with('pin', 'pin.penawaran', 'pin.tukang','pin.tukang.user')->where('kode_client',Auth::id())
                ->whereHas('pin', function ($q){
                    $q->where('status', 'N01')
                        ->orWhere('status', 'D01A')
                        ->orWhere('status', 'DO1B');
                })
                ->orderByDesc('created_at')
                ->paginate(5)->toArray();
        }
        return view('client.penawaran.v2.all')->with(compact('data'));
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
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $data = Penawaran::with('nego','pin','pin.pengajuan','pin.pengajuan.client.user','pin.tukang','pin.tukang.user','komponen','pin.pembayaran')->whereHas('pin.pengajuan.client', function ($query){
                $query->where('id', Auth::id());
            })->where(['id' => $id])->firstOrFail();

            $kode = Auth::id();

            return view('client.penawaran.v2.show')->with(compact('data', 'kode'));
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
