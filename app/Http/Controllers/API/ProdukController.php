<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProdukResourceController;
use App\Http\Resources\UserResourceController;
use App\Models\Produk;
use App\Models\Tukang;
use App\Models\User;
use App\Models\VoteRate;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;

class ProdukController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\JsonResponse|\Illuminate\Http\Response|object
     */
    public function index()
    {
        $user = Auth::user()->kode_user;
        $tukang = Tukang::find($user);
        $data = $tukang->produk()->paginate(10);
        return (new ProdukResourceController($data))->response()->setStatusCode(200);
    }

    /**
     * Store a newly created resource in storage.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|object
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_produk' => 'required',
            'harga' => 'required|integer',
            'diskripsi' => 'required',
            'path_photo' => 'required',
            'path.*' => 'mimes:jpg,jpeg,png|max:1000',
        ]);

        if ($validator->fails()) {
            return (new ProdukResourceController(['error' => $validator->errors()]))->response()->setStatusCode(401);
        }

        $id = User::with('tukang')->find(Auth::id())->kode_user;
        $request['kode_tukang'] = $id;
        if ($request->hasfile('path_photo')) {
            $files = [];
            $full_path = "";
            foreach ($request->file('path_photo') as $file) {
                if ($file->isValid()) {
                    $path = $file->store('images/produk', 'public');
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
            $data = Produk::create($request->all());
            $data['links'] = $files;
            return (new ProdukResourceController($data))->response()->setStatusCode(200);
        } else {
            $data = Produk::create($request->all());
            return (new ProdukResourceController($data))->response()->setStatusCode(200);
        }
        return (new ProdukResourceController(['error' => 'Unauthorised']))->response()->setStatusCode(401);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|object
     */
    public function show($id)
    {
        $data = Produk::find($id);

        return (new ProdukResourceController($data))->response()->setStatusCode(200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|object
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'path.*' => 'mimes:jpg,jpeg,png|max:1000',
        ]);

        if ($validator->fails()) {
            return (new ProdukResourceController(['error' => $validator->errors()]))->response()->setStatusCode(401);
        }

        if ($request->hasfile('path_photo')) {
//            $files = [];
//            $full_path = "";
//            foreach ($request->file('path_photo') as $file) {
//                if ($file->isValid()) {
//                    $path = $file->store('images/produk', 'public');
//                    $path = substr($path, 6);
//                    $path = "storage/images" . $path;
//                    if ($full_path == "") {
//                        $full_path = $path;
//                    } else {
//                        $full_path = $full_path . "," . $path;
//                    }
//                    $files[] = [
//                        'path' => $path,
//                    ];
//                }
//            }
//            $request['multipath'] = sizeof($files) > 1;
//            $request['path'] = $full_path;
//            $data = Produk::whereId($request['id'])->update($request->except('id', 'path_photo'));
//            $request['status'] = $data;
//            return (new ProdukResourceController($request))->response()->setStatusCode(200);
        } else {
            $data = Produk::whereId($request['id'])->update($request->except('id'));
            $request['status'] = $data;
            return (new ProdukResourceController($request))->response()->setStatusCode(200);
        }
        return (new ProdukResourceController(['error' => 'Unauthorised']))->response()->setStatusCode(401);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return bool|\Illuminate\Http\JsonResponse|object
     */
    public function destroy(int $id)
    {
        $data = Produk::where('id', $id)->delete();

        return (new ProdukResourceController(['id' => $id, 'status' => $data]))->response()->setStatusCode(200);
    }

    /**
     * Search the specified resource from storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return bool|\Illuminate\Http\JsonResponse|object
     */
    public function search(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'query_search' => 'required'
        ]);

        if ($validator->fails()) {
            return (new ProdukResourceController(['error' => $validator->errors()]))->response()->setStatusCode(401);
        }

        $data = Produk::with(['tukang.user' => function($q){
            $q->select('kode_user', 'name');
        }])->where('nama_produk', 'LIKE', '%' . $request->query_search . '%')->paginate(10);

        return (new ProdukResourceController($data))->response()->setStatusCode(200);
    }

    /**
     * Search the specified resource from storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return bool|\Illuminate\Http\JsonResponse|object
     */
    public function search_tukang(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'query_search' => 'required'
        ]);

        if ($validator->fails()) {
            return (new ProdukResourceController(['error' => $validator->errors()]))->response()->setStatusCode(401);
        }

        $id = User::with('tukang')->find(Auth::id())->kode_user;
        $request['kode_tukang'] = $id;
        $data = Produk::where([['kode_tukang', $id], ['nama_produk', 'LIKE', '%' . $request->query_search . '%']])->paginate(10);

        return (new ProdukResourceController($data))->response()->setStatusCode(200);
    }

    /**
     * Update the specified resource in storage.
     * @param int $id
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|object
     */
    public function update_photo(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [
            'old_path_photo' => 'string|required',
            'path.*' => 'mimes:jpg,jpeg,png|max:1000',
        ]);

        if ($validator->fails()) {
            return (new ProdukResourceController(['error' => $validator->errors()]))->response()->setStatusCode(401);
        }
        $kode_tukang = Auth::user()->kode_user;
        try {
            $pro = Produk::where('id', $id)->first();
        } catch (ModelNotFoundException $ee) {
            return (new ProdukResourceController(['error' => 'Produk tidak ditemukan di server !!!']))->response()->setStatusCode(401);
        }
        if ($kode_tukang != $pro->kode_tukang) {
            return (new ProdukResourceController(['error' => 'kamu tidak memiliki akses ke produk ini !!!']))->response()->setStatusCode(401);
        }
        $str_path = $pro->path;

        if (!str_contains($str_path, $request['old_path_photo'])) {
            return (new ProdukResourceController(['error' => 'path_photo yang anda masukan tidak terdapat pada sistem!!!']))->response()->setStatusCode(401);
        }
        try {
            $produk = Produk::where('id', $id)->first();
            if ($produk->multipath) {
                $search = $request['old_path_photo'];
                $dmp_file = explode(',', $produk->path);
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
            } else {
                $path_photo_after_replace = str_replace($request['old_path_photo'], "", $produk->path);
            }
            $new_path = "";
            $file = $request->file('path_photo');
            if ($file->isValid()) {
                $path = $file->store('images/produk', 'public');
                $path = substr($path, 6);
                $new_path = "storage/images" . $path;
            }

            $path_after_update = $path_photo_after_replace . ',' . $new_path;
            $files = explode(',', $path_after_update);
            $request['multipath'] = sizeof($files) > 1;
            $request['path'] = ['data' => $files];
            Produk::findOrFail($id)->update(['path' => $path_after_update, 'multipath' => $request['multipath']]);
            return (new ProdukResourceController($request))->response()->setStatusCode(200);
        } catch (ModelNotFoundException $ee) {
            return (new ProdukResourceController(['error' => 'Tidak ditemukan di server !!!']))->response()->setStatusCode(401);
        }
    }

    /**
     * Delete the specified resource in storage.
     * @param int $id
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|object
     */
    public function delete_photo(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [
            'path_photo' => 'string|required',
        ]);

        if ($validator->fails()) {
            return (new ProdukResourceController(['error' => $validator->errors()]))->response()->setStatusCode(401);
        }

        try {
            $produk = Produk::where('id', $id)->first();
            $str_path = $produk->path;

            if (!str_contains($str_path, $request['path_photo'])) {
                return (new ProdukResourceController(['error' => 'path_photo yang anda masukan tidak terdapat pada sistem!!!']))->response()->setStatusCode(401);
            }

            if ($produk->multipath) {
                $search = $request['old_path_photo'];
                $dmp_file = explode(',', $produk->path);
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
            } else {
                $path_photo_after_replace = str_replace($request['path_photo'], "", $produk->path);
                Produk::where('id', $id)->update(['path' => $path_photo_after_replace, 'multipath' => false]);
                $request['new_path_foto'] = $path_photo_after_replace;
                return (new ProdukResourceController($request))->response()->setStatusCode(200);
            }

            $files = explode(',', $path_photo_after_replace);
            $request['multipath'] = sizeof($files) > 1;
            $request['path'] = ['data' => $files];
            Produk::where('id', $id)->update(['path' => $path_photo_after_replace, 'multipath' => $request['multipath']]);
            return (new ProdukResourceController($request))->response()->setStatusCode(200);
        } catch (ModelNotFoundException $ee) {
            return (new ProdukResourceController(['error' => 'Tidak ditemukan di server !!!']))->response()->setStatusCode(401);
        }
    }

    /**
     * Update the specified resource in storage.
     * @param int $id
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|object
     */
    public function add_photo(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [
            'path_photo' => 'required',
            'path.*' => 'mimes:jpg,jpeg,png|max:1000',
        ]);

        if ($validator->fails()) {
            return (new ProdukResourceController(['error' => $validator->errors()]))->response()->setStatusCode(401);
        }
        try {
            $produk = Produk::where('id', $id)->first();
            $new_path = "";
            $file = $request->file('path_photo');
            if ($file->isValid()) {
                $path = $file->store('images/produk', 'public');
                $path = substr($path, 6);
                $new_path = "storage/images" . $path;
            }
            $path_after_add = $produk->path . ',' . $new_path;
            $files = explode(',', $path_after_add);
            $request['multipath'] = sizeof($files) > 1;
            $request['path'] = ['data' => $files];
            Produk::where('id', $id)->update(['path' => $path_after_add, 'multipath' => $request['multipath']]);
            return (new ProdukResourceController($request->except('path_photo')))->response()->setStatusCode(200);
        } catch (ModelNotFoundException $ee) {
            return (new ProdukResourceController(['error' => 'Tidak ditemukan di server !!!']))->response()->setStatusCode(401);
        }
    }

    //CLIENT
    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|object
     */
    public function getAllProduk()
    {
        $data = Produk::with(['tukang' => function($q){
            $q->select('id','kota','alamat');
        }])->with(['tukang.user' => function($q){
            $q->select('kode_user','name');
        }])->paginate(10);

        return (new ProdukResourceController(['data' => $data]))->response()->setStatusCode(200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|object
     */
    public function getAllProdukByTukang(int $id)
    {
        $data = Produk::where('kode_tukang', $id)->paginate(10);

        return (new ProdukResourceController(['data' => $data]))->response()->setStatusCode(200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|object
     */
    public function getDetailsProdukWTukang(int $id)
    {
        $data = Produk::with(['tukang.user' => function ($query){
            $query->select('kode_user', 'name');
        }])->with('tukang.voterate')->with('tukang.rating')->where('id', $id)->first();
        $data['tukang']['voterate_count'] = VoteRate::where('kode_tukang',$data->tukang->id)->count();
        return (new ProdukResourceController(['data' => $data]))->response()->setStatusCode(200);
    }
}
