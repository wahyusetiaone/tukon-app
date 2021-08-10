<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProgressResourceController;
use App\Models\DocumentationProgress;
use App\Models\OnProgress;
use App\Models\OnStepProgress;
use App\Models\Progress;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProgressController extends Controller
{
    /**
     * Show the form for creating a new resource.
     * @param int $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|object
     */
    public function create(Request $request, int $id)
    {

        $validator = Validator::make($request->all(), [
            'path_progress' => 'required|mimes:jpg,jpeg,png|max:1000',
        ]);

        if ($validator->fails()) {
            return (new ProgressResourceController(['error' => $validator->errors()]))->response()->setStatusCode(401);
        }
        $now = date("Y-m-d");
        //cek if project punya onprogress blm
        $has = OnProgress::with('progress')->whereHas('progress', function ($query) use ($id) {
            $query->where('kode_project', $id);
        })->select('kode_progress')
            ->groupBy('kode_progress')
            ->count();
        if ($has) {
            //amnil id progress
            $onprogress = OnProgress::with('progress')->whereHas('progress', function ($query) use ($id) {
                $query->where('kode_project', $id);
            })->groupBy('kode_progress')->first();

            //selalu true
            if ($onprogress->day >= 1) {
                //cek hari ini ada blm
                $hasToday = DocumentationProgress::with('onprogress')->whereHas('onprogress', function ($query) use ($onprogress){
                    $query->where('kode_progress',$onprogress->kode_progress );
                })->where(['date' => $now])->exists();
                //jika gak ada
                if (!$hasToday) {
                    DB::transaction(function () use ($id, $request, $now, $onprogress) {

                        $count = OnProgress::where(['kode_progress' => $onprogress->kode_progress])->count();
                        //buat on progress
                        $newonprogress = new OnProgress();
                        $newonprogress->kode_progress = $onprogress->kode_progress;
                        $newonprogress->day = $count + 1;
                        $newonprogress->save();

                        //simpan documentation
                        if ($request->hasfile('path_progress')) {
                            $file = $request->file('path_progress');
                            if ($file->isValid()) {
                                $path = $file->store('images/progress', 'public');
                                $path = substr($path, 6);
                                $path = "storage/images" . $path;
                            }
                            $data = new DocumentationProgress();
                            $data->kode_on_progress = $newonprogress->id;
                            $data->path = $path;
                            $data->date = $now;
                            $data->save();
                        }
                    });
                    return (new ProgressResourceController(['status' => true]))->response()->setStatusCode(200);
                }else{
                    //jika ada
                    $idOnProgress = DocumentationProgress::with('onprogress')->whereHas('onprogress', function ($query) use ($onprogress){
                        $query->where('kode_progress',$onprogress->kode_progress );
                    })->where(['date' => $now])->first();
                    //cek limit harian upload foto
                    $doc = OnProgress::where('id', $idOnProgress->kode_on_progress)->first();
                    if ((int)$doc->documentation == 5) {
                        return (new ProgressResourceController(['error' => 'Anda sudah mencapai limit upload foto harian.']))->response()->setStatusCode(401);
                    }
                    //simpan documentation
                    if ($request->hasfile('path_progress')) {
                        $file = $request->file('path_progress');
                        if ($file->isValid()) {
                            $path = $file->store('images/progress', 'public');
                            $path = substr($path, 6);
                            $path = "storage/images" . $path;
                        }
                        $data = new DocumentationProgress();
                        $data->kode_on_progress = $idOnProgress->kode_on_progress;
                        $data->path = $path;
                        $data->date = $now;
                        $data->save();
                    }
                    return (new ProgressResourceController(['status' => true]))->response()->setStatusCode(200);
                }
            }

            DB::transaction(function () use ($id, $request, $now, $onprogress) {
                //simpan documentation
                if ($request->hasfile('path_progress')) {
                    $file = $request->file('path_progress');
                    if ($file->isValid()) {
                        $path = $file->store('images/progress', 'public');
                        $path = substr($path, 6);
                        $path = "storage/images" . $path;
                    }
                    $data = new DocumentationProgress();
                    $data->kode_on_progress = $onprogress->id;
                    $data->path = $path;
                    $data->date = $now;
                    $data->save();
                }
            });
            return (new ProgressResourceController(['status' => true]))->response()->setStatusCode(200);
        } else {
            DB::transaction(function () use ($id, $request, $now) {
                //buat on progress
                $progress = Progress::where('kode_project', $id)->first();
                $onprogress = new OnProgress();
                $onprogress->kode_progress = $progress->id;
                $onprogress->day = 1;
                $onprogress->save();
                //simpan documentation dulu
                if ($request->hasfile('path_progress')) {
                    $file = $request->file('path_progress');
                    if ($file->isValid()) {
                        $path = $file->store('images/progress', 'public');
                        $path = substr($path, 6);
                        $path = "storage/images" . $path;
                    }
                    $data = new DocumentationProgress();
                    $data->kode_on_progress = $onprogress->id;
                    $data->path = $path;
                    $data->date = $now;
                    $data->save();
                }
            });

            return (new ProgressResourceController(['status' => true]))->response()->setStatusCode(200);
        }
    }
}
