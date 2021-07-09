<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\PenawaranResourceController;
use App\Models\Komponen;
use App\Models\Penawaran;
use App\Models\Pin;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PenawaranController extends Controller
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
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|object
     */
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kode_pin' => 'required|integer',
            'keuntungan' => 'required',
            'harga_total' => 'required',
            'nama_komponen' => 'required|array',
            'harga_komponen' => 'required|array',
        ]);

        if ($validator->fails()) {
            return (new PenawaranResourceController(['error' => $validator->errors()]))->response()->setStatusCode(401);
        }

        if (sizeof($request->input('nama_komponen')) !== sizeof($request->input('harga_komponen'))){
            return (new PenawaranResourceController(['error' => 'nama_komponen not same length with harga_komponen !']))->response()->setStatusCode(401);
        }
        $id = User::with('client')->find(Auth::id())->kode_user;
        $request['kode_client'] = $id;
        $request['kode_status'] = 'T02';
        try {
            Pin::where(['id' => $request->input('kode_pin'), 'kode_tukang' => $id])->firstOrFail();
            $data = Penawaran::create($request->except(['nama_komponen', 'harga_komponen']));
            $nama = $request->input('nama_komponen');
            $harga = $request->input('harga_komponen');
            $dump = null;
            for ($i = 0; $i < sizeof($nama); $i++ ){
                $komponen = new Komponen();
                $komponen->kode_penawaran = $data->id;
                $komponen->nama_komponen = $nama[$i];
                $komponen->harga = $harga[$i];
                $komponen->save();
                $dump[$i] = $komponen;
            }
            $data['komponen'] = $dump;
            $data['kode_pin'] = $request->input('kode_pin');
            Pin::where(['id' => $request->input('kode_pin'), 'kode_tukang' => $id])->update(['kode_penawaran' => $data->id]);
            return (new PenawaranResourceController($data))->response()->setStatusCode(200);
        } catch (ModelNotFoundException $e) {
            return (new PenawaranResourceController(['error' => $e->getMessage()]))->response()->setStatusCode(401);
        }
        return (new PenawaranResourceController(['error' => 'Unauthorised']))->response()->setStatusCode(401);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|object
     */
    public function destroy($id)
    {
        try {
            $data = Penawaran::findOrFail($id)->delete();

        } catch (ModelNotFoundException $e){
            $data['status'] = 'error';
            $data['message'] = $e->getMessage();
        }
        return (new PenawaranResourceController(['id' => $id,'status' => $data]))->response()->setStatusCode(200);
    }
}
