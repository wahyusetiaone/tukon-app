<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\PembayaranResourceController;
use App\Models\Pembayaran;
use App\Models\Transaksi_Pembayaran;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PembayaranController extends Controller
{
    /**
     * Show the form for creating a new resource.
     * @param int $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|object
     */
    public function show(int $id)
    {
        $kode_user = User::with('client')->find(Auth::id())->kode_user;

        $validasi = Pembayaran::with('pin', 'pin.pengajuan', 'pin.penawaran')->find($id);

        if ($kode_user == $validasi->pin->pengajuan->kode_client) {

            return (new PembayaranResourceController($validasi))->response()->setStatusCode(200);
        }
    }

    /**
     * Show the form for creating a new resource.
     * @param int $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|object
     */
    public function create(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [
            'note_transaksi' => 'string',
            'path_transaksi' => 'required|mimes:jpg,jpeg,png|max:1000',
        ]);

        if ($validator->fails()) {
            return (new PembayaranResourceController(['error' => $validator->errors()]))->response()->setStatusCode(401);
        }

        $kode_user = User::with('client')->find(Auth::id())->kode_user;

        $validasi = Pembayaran::with('pin', 'pin.pengajuan')->find($id);

        if ($kode_user == $validasi->pin->pengajuan->kode_client) {
            if ($validasi->kode_status == "P01" || $validasi->kode_status == "P01A"){
                if ($request->hasfile('path_transaksi')) {
                    $file = $request->file('path_transaksi');
                    $path = null;
                    if ($file->isValid()) {
                        $path = $file->store('images/pembayaran', 'public');
                        $path = substr($path, 6);
                        $path = "storage/images" . $path;
                    }

                    if (!$request->has('note_transaksi')){
                        $request['note_transaksi'] ="---";
                    }

                    $data = new Transaksi_Pembayaran();
                    $data->kode_pembayaran = $id;
                    $data->note_transaksi = $request['note_transaksi'];
                    $data->status_transaksi = "A01";
                    $data->path = $path;
                    $data->save();

                    return (new PembayaranResourceController($data))->response()->setStatusCode(200);
                }
            }
            return (new PembayaranResourceController(['error' => 'Mohon tunggu untuk admin melakukan verifikasi transaksi anda sebelumnya !!!']))->response()->setStatusCode(401);
        }
        return (new PembayaranResourceController(['error' => 'Tidak ada akses untuk merubah data ini !!!']))->response()->setStatusCode(401);

    }
}
