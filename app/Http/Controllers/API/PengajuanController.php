<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\PengajuanResourceController;
use App\Http\Resources\WishlistResourceController;
use App\Models\History_Pengajuan;
use App\Models\Pengajuan;
use App\Models\Pin;
use App\Models\Tukang;
use App\Models\User;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PengajuanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|object
     */
    public function index()
    {
        $id = User::with('client')->find(Auth::id())->kode_user;
        try {
            $data = Pengajuan::with('pin.tukang.user')->where('kode_client', $id)->paginate(10);

        } catch (ModelNotFoundException $e) {
            $data['status'] = 'error';
            $data['message'] = $e->getMessage();
            return (new PengajuanResourceController($data))->response()->setStatusCode(401);
        }
        return (new PengajuanResourceController($data))->response()->setStatusCode(200);
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
     * Show the form for creating a new resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|object
     */
    public function createformwishlist(Request $request)
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
            'kode_produk' => 'required|array'
        ]);

        if ($validator->fails()) {
            return (new PengajuanResourceController(['error' => $validator->errors()]))->response()->setStatusCode(401);
        }

        foreach ($request->input('kode_produk') as $item) {
            if (!Wishlist::where(['kode_produk' => $item])->where('kode_client', Auth::id())->exists()) {
                return (new WishlistResourceController(['error' => 'record not found.', 'kode_produk' => $item]))->response()->setStatusCode(401);
            }
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
            DB::transaction(function () use ($request, $files, &$data) {
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
                //hapus wishlist
                foreach ($request->input('kode_produk') as $item) {
                    Wishlist::where(['kode_produk' => $item])->where('kode_client', Auth::id())->delete();
                }
            });
            return (new PengajuanResourceController($data))->response()->setStatusCode(200);
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
                $request['path'] = $old->path . ',' . $full_path;
                $request['multipath'] = true;
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
            } else {
                $data = Pengajuan::findOrFail($id);
                //TODO:: need chack
//                History_Pengajuan::create($data);
                $data->update($request->all());
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
            return (new PengajuanResourceController(['id' => $id, 'status' => $data]))->response()->setStatusCode(401);
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
    public function destroy_photo(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [
            'remove_photo_path' => 'required|array',
            'remove_photo_path.*' => 'required|string',
        ]);

        if ($validator->fails()) {
            return (new PengajuanResourceController(['error' => $validator->errors()]))->response()->setStatusCode(401);
        }

        try {
            $kode_user = User::with('client')->find(Auth::id())->kode_user;
            foreach ($request->input('remove_photo_path') as $item) {
                $data = Pengajuan::where(['id' => $id, 'kode_client' => $kode_user])->firstOrFail();
                if ($data->multipath) {
                    $search = $item;
                    $dmp_file = explode(',', $data->path);
                    $path_photo_after_replace = null;
                    foreach ($dmp_file as $dmp) {
                        if ((string)$search != (string)$dmp) {
                            if (empty($path_photo_after_replace)) {
                                $path_photo_after_replace = $path_photo_after_replace . $dmp;
                            } else {
                                $path_photo_after_replace = $path_photo_after_replace . ',' . $dmp;
                            }
                        }
                    }
                    $files = explode(',', $path_photo_after_replace);
                    $request['multipath'] = sizeof($files) > 1;
                    Pengajuan::where('id', $id)->update(['path' => $path_photo_after_replace, 'multipath' => $request['multipath']]);
                } else {
                    $path_photo_after_replace = str_replace($item, "", $data->path);
                    Pengajuan::where('id', $id)->update(['path' => $path_photo_after_replace, 'multipath' => false]);
                    $request['new_path_foto'] = $path_photo_after_replace;
                }
            }
            return (new PengajuanResourceController($request))->response()->setStatusCode(200);
        } catch (ModelNotFoundException $e) {
            $data['status'] = 'error';
            $data['message'] = $e->getMessage();
            return (new PengajuanResourceController(['id' => $id, 'status' => $data]))->response()->setStatusCode(401);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|object
     */
    public function destroy_tukang(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [
            'kode_pin' => 'required',
        ]);

        if ($validator->fails()) {
            return (new PengajuanResourceController(['error' => $validator->errors()]))->response()->setStatusCode(401);
        }

        try {
            $kode_user = User::with('client')->find(Auth::id())->kode_user;
            $data = Pengajuan::where(['id' => $id, 'kode_client' => $kode_user])->firstOrFail();
            try {
                $res = Pin::where(['id' => $request->kode_pin, 'kode_pengajuan' => $id])->firstOrFail();
                $res->delete();
                return (new PengajuanResourceController([$data, 'kode_pin' => $request->kode_pin]))->response()->setStatusCode(200);
            } catch (ModelNotFoundException $ee) {
                return (new PengajuanResourceController(['status' => 0, 'error' => 'record not found or you do have access this record.', 'message' => $ee->getMessage()]))->response()->setStatusCode(401);
            }
        } catch (ModelNotFoundException $e) {
            $data['status'] = 'error';
            $data['message'] = $e->getMessage();
        }
        return (new PengajuanResourceController([$res, $data]))->response()->setStatusCode(401);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $kode_pengajuan
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|object
     */
    public function get_tukang_by_pengajuan(int $kode_pengajuan)
    {
        try {
            $data = Pengajuan::with('pin.penawaran.komponen', 'pin.tukang.user')->where('id', $kode_pengajuan)->get();
            return (new PengajuanResourceController($data))->response()->setStatusCode(200);
        } catch (ModelNotFoundException $ee) {
            return (new PengajuanResourceController(['status' => 0, 'error' => 'record not found or you do have access this record.', 'message' => $ee->getMessage()]))->response()->setStatusCode(401);
        }
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|object
     */
    public function pengajuan_base_tukang()
    {
        $id = User::with('tukang')->find(Auth::id())->kode_user;
        try {
            $data = Pin::with('pengajuan', 'pengajuan.client', 'pengajuan.client.user')->where('kode_tukang', $id)->paginate(10);

        } catch (ModelNotFoundException $e) {
            $data['status'] = 'error';
            $data['message'] = $e->getMessage();
            return (new PengajuanResourceController($data))->response()->setStatusCode(401);
        }
        return (new PengajuanResourceController($data))->response()->setStatusCode(200);
    }

    /**
     * Tolak pengajuan base on PIN the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|object
     */

    public function tolak_pengajuan(int $id)
    {
        $kode_user = User::with('tukang')->find(Auth::id())->kode_user;
        try {
            $old = Pin::where(['id' => $id, 'kode_tukang' => $kode_user])->firstOrFail();
            $old->update(['status' => 'B02']);

            return (new PengajuanResourceController(['update_status' => $old]))->response()->setStatusCode(200);
        } catch (ModelNotFoundException $e) {
            return (new PengajuanResourceController(['error' => $e->getMessage()]))->response()->setStatusCode(401);
        }
    }
}
