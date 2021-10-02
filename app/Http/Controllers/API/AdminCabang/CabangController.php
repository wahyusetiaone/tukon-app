<?php

namespace App\Http\Controllers\API\AdminCabang;

use App\Http\Controllers\Controller;
use App\Http\Resources\CabangResourceController;
use App\Http\Resources\TukangResourceController;
use App\Models\Admin;
use App\Models\HasCabang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CabangController extends Controller
{
    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|object
     */
    public function index()
    {
        $data = Admin::with('has_cabang.cabang')->whereId(Auth::id())->paginate(10);

        return (new CabangResourceController(['data' => $data]))->response()->setStatusCode(200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|object
     */
    public function getTukangFromCabang(Request $request,int $idcabang)
    {
        if ($request->input('only') == 'unverified') {
            $data = HasCabang::with('cabang.tukang')
                ->whereHas('cabang.tukang', function ($q){
                    $q->where('verifikasi_lokasi', false);
                })
                ->where('cabang_id', $idcabang)
                ->where('admin_id',Auth::id())->paginate(10);
        }else if ($request->input('only') == 'verified') {
            $data = HasCabang::with('cabang.tukang')
                ->whereHas('cabang.tukang', function ($q){
                    $q->where('verifikasi_lokasi', true);
                })
                ->where('cabang_id', $idcabang)
                ->where('admin_id',Auth::id())->paginate(10);
        }

        return (new CabangResourceController(['data' => $data]))->response()->setStatusCode(200);
    }
}
