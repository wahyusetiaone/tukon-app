<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\RatingResourceController;
use App\Models\Project;
use App\Models\VoteRate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class RatingController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param int $kode_project
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|object
     */
    public function send(Request $request, int $kode_project)
    {
        if (!Project::where('id', $kode_project)->exists()){
            return (new RatingResourceController(['error'=>'Proyek tidak ditemukan']))->response()->setStatusCode(401);
        }
        if (VoteRate::where('kode_project', $kode_project)->exists()){
            return (new RatingResourceController(['error'=>' Proyek ini sudah diberi rating !!!']))->response()->setStatusCode(401);
        }
        $project = Project::select('kode_status')->where('id', $kode_project)->first();
        if ($project->kode_status != "ON05"){
            return (new RatingResourceController(['error'=>'Proyek masih dalam progress, anda tidak dapat melakukan penilaian. Mohon tunggu hingga proyek selesai !!!']))->response()->setStatusCode(401);
        }

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
        $vote->kode_project = $kode_project;
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

    /**
     * Display a listing of the resource.
     * @param int $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|object
     */
    public function get(Request $request, int $id)
    {
        if (!Project::where('id', $id)->exists()){
            return (new RatingResourceController(['error' => 'Kode Proyek tidak ditemukan.']))->response()->setStatusCode(200);
        }
        if (!VoteRate::where('kode_project', $id)->exists()){
            return (new RatingResourceController(['error' => 'Vote Rate untuk Kode Proyek ini belum ada.']))->response()->setStatusCode(200);
        }
        $data = VoteRate::where('kode_project', $id)->first;

        return (new RatingResourceController(['data' => $data]))->response()->setStatusCode(200);

    }
}
