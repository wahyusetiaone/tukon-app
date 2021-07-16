<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProgressResourceController;
use App\Models\OnStepProgress;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProgressController extends Controller
{
    /**
     * Show the form for creating a new resource.
     * @param int $id_project
     * @param int $id_progress
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|object
     */
    public function create(Request $request, int $id_project, int $id_progress)
    {
        $validator = Validator::make($request->all(), [
            'note_progress' => 'string',
            'path_progress' => 'required|mimes:jpg,jpeg,png|max:1000',
        ]);

        if ($validator->fails()) {
            return (new ProgressResourceController(['error' => $validator->errors()]))->response()->setStatusCode(401);
        }

        $kode_user = User::with('client')->find(Auth::id())->kode_user;

        $validasi = Project::with('pembayaran', 'pembayaran.pin')->find($id_project);

        if ($kode_user == $validasi->pembayaran->pin->kode_tukang) {
            if (!OnStepProgress::where(['kode_project' => $id_project, 'kode_plan_progress' => $id_progress])->exists()) {
                if ($request->hasfile('path_progress')) {
                    $file = $request->file('path_progress');
                    if ($file->isValid()) {
                        $path = $file->store('images/progress', 'public');
                        $path = substr($path, 6);
                        $path = "storage/images" . $path;
                    }
                    $data = new OnStepProgress();
                    $data->kode_project = $id_project;
                    $data->kode_plan_progress = $id_progress;
                    $data->path = $path;
                    $data->note_step_progress = $request['note_progress'];
                    $data->save();
                    return (new ProgressResourceController($data))->response()->setStatusCode(200);
                }
            }
            return (new ProgressResourceController(['error' => 'Anda telah melakukan upload progress pada tahap ini !!!']))->response()->setStatusCode(401);
        }
        return (new ProgressResourceController(['error' => 'Tidak ada akses untuk merubah data ini !!!']))->response()->setStatusCode(401);

    }
}
