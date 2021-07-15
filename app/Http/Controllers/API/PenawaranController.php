<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\PenawaranResourceController;
use App\Models\History_Penawaran;
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

        if (sizeof($request->input('nama_komponen')) !== sizeof($request->input('harga_komponen'))) {
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
            for ($i = 0; $i < sizeof($nama); $i++) {
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
        if (!count($request->all())) {
            return (new PenawaranResourceController(['error' => 'mush have one input.']))->response()->setStatusCode(401);
        }

        $validator = Validator::make($request->all(), [
            'keuntungan' => 'integer',
            'harga_total' => 'integer',
            'nama_komponen' => 'array',
            'harga_komponen' => 'array',
        ]);

        if ($validator->fails()) {
            return (new PenawaranResourceController(['error' => $validator->errors()]))->response()->setStatusCode(401);
        }

        if ($request->has('nama_komponen') && $request->has('harga_komponen')) {
            if (sizeof($request->input('nama_komponen')) !== sizeof($request->input('harga_komponen'))) {
                return (new PenawaranResourceController(['error' => 'nama_komponen not same length with harga_komponen !']))->response()->setStatusCode(401);
            }
        }
        $kode_user = User::with('tukang')->find(Auth::id())->kode_user;
        $request['kode_tukang'] = $kode_user;
        $request['kode_status'] = 'S02';
        try {
            Pin::where(['kode_penawaran' => $id, 'kode_tukang' => $kode_user])->firstOrFail();
            $data = Penawaran::findOrFail($id);
            //TODO:: AS NOTE this is create history
//            History_Penawaran::create($data);
            $data->update($request->except(['nama_komponen', 'harga_komponen', 'kode_client']));
            if ($request->has('nama_komponen') && $request->has('harga_komponen')) {
                $nama = $request->input('nama_komponen');
                $harga = $request->input('harga_komponen');
                $dump = null;
                for ($i = 0; $i < sizeof($nama); $i++) {
                    $komponen = new Komponen();
                    $komponen->kode_penawaran = $data->id;
                    $komponen->nama_komponen = $nama[$i];
                    $komponen->harga = $harga[$i];
                    $komponen->save();
                    $dump[$i] = $komponen;
                }
                $request['komponen'] = $dump;
            }
            return (new PenawaranResourceController($request))->response()->setStatusCode(200);
        } catch (ModelNotFoundException $e) {
            return (new PenawaranResourceController(['error' => $e->getMessage()]))->response()->setStatusCode(401);
        }
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
            $data = Penawaran::findOrFail($id)->delete();

        } catch (ModelNotFoundException $e) {
            $data['status'] = 'error';
            $data['message'] = $e->getMessage();
        }
        return (new PenawaranResourceController(['id' => $id, 'status' => $data]))->response()->setStatusCode(200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|object
     */
    public function destroy_komponen($id)
    {
        $kode_user = User::with('tukang')->find(Auth::id())->kode_user;
        try {
            $komponen = Komponen::with('penawaran', 'penawaran.pin')->findOrFail($id);
            $read_kode_tukang = $komponen->penawaran->pin->kode_tukang;
            if ( $read_kode_tukang == $kode_user){
                $data = Komponen::findOrFail($id)->delete();
                $komponen['status'] = $data;
                return (new PenawaranResourceController($komponen))->response()->setStatusCode(200);
            }else{
                return (new PenawaranResourceController(['error' => 'you not have permission to modif this record !']))->response()->setStatusCode(401);
            }
        } catch (ModelNotFoundException $e) {
            return (new PenawaranResourceController(['error' => $e->getMessage()]))->response()->setStatusCode(401);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|object
     */
    public function update_komponen(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama_komponen' => 'required|string',
            'harga_komponen' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return (new PenawaranResourceController(['error' => $validator->errors()]))->response()->setStatusCode(401);
        }

        $kode_user = User::with('tukang')->find(Auth::id())->kode_user;
        try {
            $komponen = Komponen::with('penawaran', 'penawaran.pin')->findOrFail($id);
            $read_kode_tukang = $komponen->penawaran->pin->kode_tukang;
            if ( $read_kode_tukang == $kode_user){
                $komponen['harga'] = $request->input('harga_komponen');
                $stat = $komponen->update($request->except('harga_komponen'));
                $komponen['status'] = $stat;
                return (new PenawaranResourceController($komponen))->response()->setStatusCode(200);
            }else{
                return (new PenawaranResourceController(['error' => 'you not have permission to modif this record !']))->response()->setStatusCode(401);
            }
        } catch (ModelNotFoundException $e) {
            return (new PenawaranResourceController(['error' => $e->getMessage()]))->response()->setStatusCode(401);
        }
    }
}
