<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use App\Models\Project;
use App\Models\Tukang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class TukangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        $tukang = Tukang::with('user')->paginate(9);

        if (Auth::check()){
            if (Auth::user()->kode_role == 2){
                return view('guest.tukang.v2.all_for_tukang')->with(compact('tukang'));
            }
        }
        return view('guest.tukang.v2.all')->with(compact('tukang'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index_top()
    {
        $tukang = Tukang::with('user')->orderBy('rate', 'desc')->paginate(9);

        if (Auth::check()){
            if (Auth::user()->kode_role == 2){
                return view('guest.tukang.v2.all_for_tukang')->with(compact('tukang'));
            }
        }
        return view('guest.tukang.v2.all')->with(compact('tukang'));
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

        if (Auth::check()){
            if (Auth::user()->kode_role == 2){
                return view('guest.tukang.v2.show_for_tukang')->with(compact('tukang', 'produk', 'proyek'));
            }
        }
        return view('guest.tukang.v2.show')->with(compact('tukang', 'produk', 'proyek'));
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
