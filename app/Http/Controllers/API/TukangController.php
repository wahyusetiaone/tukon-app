<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\TukangResourceController;
use App\Models\Tukang;
use Illuminate\Http\Request;

class TukangController extends Controller
{
    //CLIENT
    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|object
     */
    public function getAllTukang()
    {
        $data = Tukang::paginate(10);

        return (new TukangResourceController(['data' => $data]))->response()->setStatusCode(200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|object
     */
    public function show(int $id)
    {
        $data = Tukang::with('user')->where('id', $id)->first();

        return (new TukangResourceController(['data' => $data]))->response()->setStatusCode(200);
    }
}
