<?php

namespace App\Http\Controllers\Tukang;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProgressResourceController;
use App\Models\DocumentationProgress;
use App\Models\OnProgress;
use App\Models\Progress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class ProgressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create(int $id)
    {
        return view('tukang.progress.upload')->with(compact('id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param int $id
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, int $id)
    {
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
                $hasToday = DocumentationProgress::with('onprogress')->whereHas('onprogress', function ($query) use ($onprogress) {
                    $query->where('kode_progress', $onprogress->kode_progress);
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
                            $data->note_progress = $request->input('note_progress');
                            $data->path = $path;
                            $data->date = $now;
                            $data->save();
                        }
                    });
                    Alert::success('Upload Progress', 'Progress berhasil di upload !!!');
                    return redirect()->route('show.projek', $id);
                } else {
                    //jika ada
                    $idOnProgress = DocumentationProgress::with('onprogress')->whereHas('onprogress', function ($query) use ($onprogress) {
                        $query->where('kode_progress', $onprogress->kode_progress);
                    })->where(['date' => $now])->first();
                    //cek limit harian upload foto
                    $doc = OnProgress::where('id', $idOnProgress->kode_on_progress)->first();
                    if ((int)$doc->documentation == 5) {
                        Alert::success('Error Upload Progress', 'Anda sudah mencapai limit upload foto harian !!!');
                        return redirect()->route('show.projek', $id);
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
                        $data->note_progress = $request->input('note_progress');
                        $data->path = $path;
                        $data->date = $now;
                        $data->save();
                    }
                    Alert::success('Upload Progress', 'Progress berhasil di upload !!!');
                    return redirect()->route('show.projek', $id);
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
                    $data->note_progress = $request->input('note_progress');
                    $data->path = $path;
                    $data->date = $now;
                    $data->save();
                }
            });
            Alert::success('Upload Progress', 'Progress berhasil di upload !!!');
            return redirect()->route('show.projek', $id);
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
                    $data->note_progress = $request->input('note_progress');
                    $data->path = $path;
                    $data->date = $now;
                    $data->save();
                }
            });

            Alert::success('Upload Progress', 'Progress berhasil di upload !!!');
            return redirect()->route('show.projek', $id);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
