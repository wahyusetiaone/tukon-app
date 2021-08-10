<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\RatingResourceController;
use App\Models\VoteRate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class RatingController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|object
     */
    public function send(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kode_tukang' => 'required',
            'value' => 'required',

        ]);

        if ($validator->fails()) {
            return (new RatingResourceController(['error'=>$validator->errors()]))->response()->setStatusCode(401);
        }

        $kode_client = Auth::user();
        $kode_client = $kode_client->kode_user;
        $vote = new VoteRate();
        $vote->kode_tukang = $request->input('kode_tukang');
        $vote->kode_client = $kode_client;
        $vote->value = $request->input('value');
        $vote->save();

        return (new RatingResourceController($vote))->response()->setStatusCode(200);
    }

    /**
     * Display a listing of the resource.
     * @param int $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|object
     */
    public function change(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [
            'kode_tukang' => 'required',
            'value' => 'required'
        ]);

        if ($validator->fails()) {
            return (new RatingResourceController(['error'=>$validator->errors()]))->response()->setStatusCode(401);
        }

        $remove_rate = VoteRate::destroy($id);

        if ($remove_rate) {
            $kode_client = Auth::user();
            $kode_client = $kode_client->kode_user;
            $vote = new VoteRate();
            $vote->id = $id;
            $vote->kode_tukang = $request->input('kode_tukang');
            $vote->kode_client = $kode_client;
            $vote->value = $request->input('value');
            $vote->save();
            return (new RatingResourceController($vote))->response()->setStatusCode(200);
        }
        return (new RatingResourceController(['error' => 'some error found.']))->response()->setStatusCode(200);

    }
}
