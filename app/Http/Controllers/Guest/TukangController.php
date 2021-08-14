<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use App\Models\Project;
use App\Models\Tukang;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TukangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        if (!Tukang::where('id',$id)->exists()){
            return View('errors.404');
        }
        $tukang = Tukang::with('user', 'rating')->withCount(['produk', 'voterate'])->where('id',$id)->first();
        $produk = Produk::where('kode_tukang', $id)->paginate(9);
        $proyek = Project::whereHas('pembayaran.pin', function ($q) use ($id){
            $q->where(['kode_tukang' => $id]);
        })->whereHas('pembayaran.project', function ($q){
            $q->where(['kode_status' => 'ON05']);
        })->count();
        return view('client.guest.show')->with(compact('tukang', 'produk', 'proyek'));
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
