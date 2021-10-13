<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\PenawaranResourceController;
use App\Models\BPA;
use App\Models\History_Penawaran;
use App\Models\Komponen;
use App\Models\Penawaran;
use App\Models\Pin;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\Console\Input\Input;

class PenawaranControllerV2 extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|object
     */
    public function index(Request $request)
    {
        $id = Auth::id();
        try {
            if ($request->input('only') == 'batal') {
                $data = Penawaran::with('bpa', 'pin', 'pin.pembayaran', 'pin.pengajuan', 'pin.pengajuan.client', 'pin.pengajuan.client.user')->whereHas('pin', function ($query) use ($id) {
                    $query->where([['kode_tukang', $id], ['status', 'B01']])
                        ->orWhere([['kode_tukang', $id], ['status', 'B02']])
                        ->orWhere([['kode_tukang', $id], ['status', 'B04']]);
                })->paginate(10);
            } elseif ($request->input('only') == 'menunggu-pembayaran') {
                $data = Penawaran::with('bpa', 'pin', 'pin.pembayaran', 'pin.pengajuan', 'pin.pengajuan.client', 'pin.pengajuan.client.user')->whereHas('pin', function ($query) use ($id) {
                    $query->where([['kode_tukang', $id], ['status', 'D02']]);
                })->whereHas('pin.pembayaran', function ($q){
                    $q->where('kode_status', 'P01');
                })->paginate(10);
            } else {
                $data = Penawaran::with('bpa', 'pin', 'pin.pembayaran', 'pin.pengajuan', 'pin.pengajuan.client', 'pin.pengajuan.client.user')->whereHas('pin', function ($query) use ($id) {
                    $query->where([['kode_tukang', $id], ['status', 'N01']]);
                    $query->orWhere([['kode_tukang', $id], ['status', 'D01A']]);
                    $query->orWhere([['kode_tukang', $id], ['status', 'D01B']]);
                })->paginate(10);
            }
            return (new PenawaranResourceController($data))->response()->setStatusCode(200);
        } catch (ModelNotFoundException $e) {
            return (new PenawaranResourceController(['error' => 'Item penawaran tidak ditemukan.']))->response()->setStatusCode(401);
        }
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
            'kode_spd' => 'required|integer',
            'keuntungan' => 'required|integer',
            'kode_bpa' => 'required|integer',
            'kode_bac' => 'required|integer',
            'harga' => 'required|integer',
            'harga_total' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return (new PenawaranResourceController(['error' => $validator->errors()]))->response()->setStatusCode(401);
        }

        $id = User::with('tukang')->find(Auth::id())->kode_user;
        $request['kode_status'] = 'T02';
        try {
            Pin::where(['id' => $request->input('kode_pin'), 'kode_tukang' => $id])->firstOrFail();
            $data = Penawaran::create($request->all());
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
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|object
     */
    public function show($id)
    {

        if (!Penawaran::whereId($id)->exists()) {
            return (new PenawaranResourceController(['error' => 'Item penawaran tidak ditemukan.']))->response()->setStatusCode(401);
        }

        try {
            $data = Penawaran::with('bpa','nego', 'bac', 'pin', 'pin.pembayaran', 'pin.pengajuan.berkas', 'pin.pengajuan.client', 'pin.pengajuan.client.user')->where('id', $id)->first();
            if (Auth::id() != $data->pin->kode_tukang) {
                return (new PenawaranResourceController(['error' => 'Anda tidak mempunyai akses atas item penawaran ini !']))->response()->setStatusCode(401);
            }
            return (new PenawaranResourceController($data))->response()->setStatusCode(200);
        } catch (ModelNotFoundException $e) {
            return (new PenawaranResourceController(['error' => 'Item penawaran tidak ditemukan.']))->response()->setStatusCode(401);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|object
     */
    public function showclient($id)
    {
        try {
            $data = Penawaran::with('pin','nego', 'pin.tukang.user', 'pin.pengajuan', 'pin.pengajuan.client', 'pin.pengajuan.client.user')->where('id', $id)->firstOrFail();
            if (Auth::id() != $data->pin->pengajuan->kode_client) {
                return (new PenawaranResourceController(['error' => 'Anda tidak mempunyai akses atas item penawaran ini !']))->response()->setStatusCode(401);
            }
            return (new PenawaranResourceController($data))->response()->setStatusCode(200);
        } catch (ModelNotFoundException $e) {
            return (new PenawaranResourceController(['error' => 'Item penawaran tidak ditemukan.']))->response()->setStatusCode(401);
        }
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
            'kode_pin' => 'integer',
            'kode_spd' => 'integer',
            'keuntungan' => 'required',
            'kode_bpa' => 'integer',
            'kode_bac' => 'integer',
            'harga' => 'integer',
            'harga_total' => 'integer',
        ]);

        if ($validator->fails()) {
            return (new PenawaranResourceController(['error' => $validator->errors()]))->response()->setStatusCode(401);
        }

        $kode_user = User::with('tukang')->find(Auth::id())->kode_user;
        $request['kode_tukang'] = $kode_user;
        $request['kode_status'] = 'S02';
        try {
            Pin::where(['kode_penawaran' => $id, 'kode_tukang' => $kode_user])->firstOrFail();
            $data = Penawaran::findOrFail($id);
            $data->update($request->except(['kode_client']));
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
}
