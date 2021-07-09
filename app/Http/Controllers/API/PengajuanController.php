<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\PengajuanResourceController;
use App\Models\Pengajuan;
use App\Models\Pin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PengajuanController extends Controller
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
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|object
     */
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_proyek' => 'required',
            'diskripsi_proyek' => 'required',
            'alamat' => 'required',
            'deadline' => 'required|date_format:Y-m-d H:i:s',
            'range_min' => 'required|integer',
            'range_max' => 'required|integer',
            'kode_tukang' => 'required|array',
            'path_photo' => 'required|array',
            'path_photo.*' => 'mimes:jpg,jpeg,png|max:1000',
        ]);

        if ($validator->fails()) {
            return (new PengajuanResourceController(['error' => $validator->errors()]))->response()->setStatusCode(401);
        }

        $id = User::with('client')->find(Auth::id())->kode_user;
        $request['kode_client'] = $id;
        if ($request->hasfile('path_photo')) {
            $files = [];
            $full_path = "";
            foreach ($request->file('path_photo') as $file) {
                if ($file->isValid()) {
                    $path = $file->store('images/pengajuan/project', 'public');
                    $path = substr($path, 6);
                    $path = "storage/images" . $path;
                    if ($full_path == "") {
                        $full_path = $path;
                    } else {
                        $full_path = $full_path . "," . $path;
                    }
                    $files[] = [
                        'path' => $path,
                    ];
                }
            }
            $request['multipath'] = sizeof($files) > 1;
            $request['path'] = $full_path;
            $request['offline'] = false;
            $request['kode_status'] = 'T01';
            $data = Pengajuan::create($request->except(['kode_tukang']));
            $data['links'] = $files;
            foreach ($request->input('kode_tukang') as $tukang) {
                $pin = new Pin();
                $pin->kode_pengajuan = $data->id;
                $pin->kode_tukang = $tukang;
                $pin->status = "N01";
                $pin->save();
            }
            $data['kode_tukang'] = $request->input('kode_tukang');
            return (new PengajuanResourceController($data))->response()->setStatusCode(200);
        } else {
//            THIS USELESS
//            $data = Pengajuan::create($request->except(['kode_tukang']));
//            return (new PengajuanResourceController($data))->response()->setStatusCode(200);
        }
        return (new PengajuanResourceController(['error' => 'Unauthorised']))->response()->setStatusCode(401);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|object
     */

    //TODO:: Update image path must be check multipath status
    // because if old data is false and add photo by update will not be change it.//
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama_proyek' => 'string',
            'diskripsi_proyek' => 'string',
            'alamat' => 'string',
            'deadline' => 'date_format:Y-m-d H:i:s',
            'range_min' => 'integer',
            'range_max' => 'integer',
            'kode_tukang' => 'array',
            'path_photo' => 'array',
            'path_photo.*' => 'mimes:jpg,jpeg,png|max:1000',
        ]);

        if ($validator->fails()) {
            return (new PengajuanResourceController(['error' => $validator->errors()]))->response()->setStatusCode(401);
        }

        $kode_user = User::with('client')->find(Auth::id())->kode_user;
        $request['kode_client'] = $kode_user;
        try {
            $old = Pengajuan::where(['id' => $id, 'kode_client' => $kode_user])->firstOrFail();

            //use foto
            if ($request->hasfile('path_photo')) {
                $files = [];
                $full_path = "";
                foreach ($request->file('path_photo') as $file) {
                    if ($file->isValid()) {
                        $path = $file->store('images/pengajuan/project', 'public');
                        $path = substr($path, 6);
                        $path = "storage/images" . $path;
                        if ($full_path == "") {
                            $full_path = $path;
                        } else {
                            $full_path = $full_path . "," . $path;
                        }
                        $files[] = [
                            'path' => $path,
                        ];
                    }
                }
                $request['multipath'] = sizeof($files) > 1;
                $request['path'] = $old->path.','.$full_path;
                $request['kode_status'] = 'T02';
                $data = Pengajuan::findOrFail($id)->update($request->except(['path_photo', 'kode_tukang']));
                if ($request->has('kode_tukang')) {
                    foreach ($request->input('kode_tukang') as $tukang) {
                        $pin = new Pin();
                        $pin->kode_pengajuan = $data->id;
                        $pin->kode_tukang = $tukang;
                        $pin->status = "N01";
                        $pin->save();
                    }
                }
                return (new PengajuanResourceController(['update_status' => $data]))->response()->setStatusCode(200);
            } else if ($request->has('kode_tukang')) {

                $request['kode_status'] = 'T02';
                $data = Pengajuan::findOrFail($id);
                foreach ($request->input('kode_tukang') as $tukang) {
                    $pin = new Pin();
                    $pin->kode_pengajuan = $data->id;
                    $pin->kode_tukang = $tukang;
                    $pin->status = "N01";
                    $pin->save();
                }
                $data->update($request->except(['kode_tukang']));
                $data['kode_tukang'] = $request->input('kode_tukang');
                return (new PengajuanResourceController($data))->response()->setStatusCode(200);
            } else{
                $data = Pengajuan::findOrFail($id)->update($request->all());
                return (new PengajuanResourceController(['update_status' => $data]))->response()->setStatusCode(200);
            }
        } catch (ModelNotFoundException $e) {
            return (new PengajuanResourceController(['error' => $e->getMessage()]))->response()->setStatusCode(401);
        }


        return (new PengajuanResourceController(['error' => 'Unauthorised']))->response()->setStatusCode(401);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|object
     */
    public function destroy($id)
    {
        try {
            $data = Pengajuan::findOrFail($id)->delete();

        } catch (ModelNotFoundException $e) {
            $data['status'] = 'error';
            $data['message'] = $e->getMessage();
        }
        return (new PengajuanResourceController(['id' => $id, 'status' => $data]))->response()->setStatusCode(200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|object
     */
    public function destroy_photo(Request $request,int $id)
    {
        try {
            $kode_user = User::with('client')->find(Auth::id())->kode_user;
            $data = Pengajuan::where(['id'=>$id, 'kode_client' => $kode_user])->firstOrFail();
            $old_path = $data->path;
            if ($data->multipath){
                $query = $request->input('remove_photo_path').',';
            }else{
                $query = $request->input('remove_photo_path');
            }
            if(strpos($old_path, $query) !== false){
                $new_path = str_replace($query, '', $old_path);
                $data->update(['path' => $new_path]);
            } else{
                return (new PengajuanResourceController(['status' => 0, 'error' => 'path photo cant found', 'path'=>$query]))->response()->setStatusCode(401);
            }
        } catch (ModelNotFoundException $e) {
            $data['status'] = 'error';
            $data['message'] = $e->getMessage();
        }
        return (new PengajuanResourceController(['id' => $id, 'status' => $data, 'new_path' => $new_path]))->response()->setStatusCode(200);
    }
}
