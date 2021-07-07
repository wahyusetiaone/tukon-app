<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\RatingResourceController;
use App\Models\VoteRate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|object
     */
    public function send(Request $request)
    {
        $kode_client = Auth::user();
        $kode_client = $kode_client->kode_user;
        $vote = new VoteRate();
        $vote->kode_tukang = $request->input('kode_tukang');
        $vote->kode_client = $kode_client;
        $vote->value = $request->input('value');
        $vote->save();

        return (new RatingResourceController($vote))->response()->setStatusCode(200);
    }
}
