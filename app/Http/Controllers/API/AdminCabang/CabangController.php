<?php

namespace App\Http\Controllers\API\AdminCabang;

use App\Http\Controllers\Controller;
use App\Http\Resources\CabangResourceController;
use App\Http\Resources\TukangResourceController;
use App\Models\Admin;
use App\Models\HasCabang;
use App\Models\Tukang;
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
        $data = Admin::with('has_cabang.cabang')->whereId(Auth::id())->first();

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
            $data = Tukang::with('user')
                ->whereHas('cabang',function ($q) use ($idcabang){
                    $q->where('id', $idcabang);
                })
                ->where('verifikasi_lokasi', false)
                ->paginate(10);
        }else if ($request->input('only') == 'verified') {
            $data = Tukang::with('user')
                ->whereHas('cabang',function ($q) use ($idcabang){
                    $q->where('id', $idcabang);
                })
                ->where('verifikasi_lokasi', true)->paginate(10);
        }

        return (new CabangResourceController(['data' => $data]))->response()->setStatusCode(200);
    }
}
