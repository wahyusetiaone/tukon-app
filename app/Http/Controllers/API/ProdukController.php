<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProdukResourceController;
use App\Http\Resources\UserResourceController;
use App\Models\Produk;
use App\Models\Tukang;
use App\Models\User;
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
        $data = $tukang->produk;
        return (new ProdukResourceController($data))->response()->setStatusCode(200);
    }

    /**
     * Store a newly created resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|object
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_produk' => 'required',
            'range_min' => 'required|integer',
            'range_max' => 'required|integer',
            'diskripsi' => 'required',
            'path_photo' => 'required',
            'path.*' => 'mimes:jpg,jpeg,png|max:1000',
        ]);

        if ($validator->fails()) {
            return (new ProdukResourceController(['error'=>$validator->errors()]))->response()->setStatusCode(401);
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
                    $path = "storage".$path;
                    if ($full_path == ""){
                        $full_path = $path;
                    }else{
                        $full_path = $full_path.",".$path;
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
        }else{
            $data = Produk::create($request->all());
            Alert::success('Succesfully Saved', 'Data has been saved !!!');
            return (new ProdukResourceController($data))->response()->setStatusCode(200);
        }
        return (new ProdukResourceController(['error'=>'Unauthorised']))->response()->setStatusCode(401);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
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
     * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|object
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'path.*' => 'mimes:jpg,jpeg,png|max:1000',
        ]);

        if ($validator->fails()) {
            return (new ProdukResourceController(['error'=>$validator->errors()]))->response()->setStatusCode(401);
        }

        if ($request->hasfile('path_photo')) {
            $files = [];
            $full_path = "";
            foreach ($request->file('path_photo') as $file) {
                if ($file->isValid()) {
                    $path = $file->store('images/produk', 'public');
                    $path = substr($path, 6);
                    $path = "storage".$path;
                    if ($full_path == ""){
                        $full_path = $path;
                    }else{
                        $full_path = $full_path.",".$path;
                    }
                    $files[] = [
                        'path' => $path,
                    ];
                }
            }
            $request['multipath'] = sizeof($files) > 1;
            $request['path'] = $full_path;
            $data = Produk::whereId($request['id'])->update($request->except('id'));
            $data['links'] = $files;
            $request['status'] = $data;
            return (new ProdukResourceController($request))->response()->setStatusCode(200);
        }else{
            $data = Produk::whereId($request['id'])->update($request->except('id'));
            $request['status'] = $data;
            return (new ProdukResourceController($request))->response()->setStatusCode(200);
        }
        return (new ProdukResourceController(['error'=>'Unauthorised']))->response()->setStatusCode(401);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return bool|\Illuminate\Http\JsonResponse|object
     */
    public function destroy(int $id)
    {
        $data = Produk::where('id',$id)->delete();

        return (new ProdukResourceController(['id' => $id,'status' => $data]))->response()->setStatusCode(200);
    }
}
