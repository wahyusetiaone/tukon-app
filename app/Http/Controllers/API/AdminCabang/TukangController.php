<?php

namespace App\Http\Controllers\API\AdminCabang;

use App\Http\Controllers\Controller;
use App\Http\Resources\TukangResourceController;
use App\Models\Admin;
use App\Models\Tukang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TukangController extends Controller
{
    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|object
     */
    public function show(int $id)
    {
        $data = Tukang::with('user','foto_kantor','verification')->whereId($id)->first();

        return (new TukangResourceController(['data' => $data]))->response()->setStatusCode(200);
    }
}
