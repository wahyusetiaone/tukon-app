<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\PembayaranResourceController;
use App\Models\Pembayaran;
use App\Models\Pin;
use App\Models\Transaksi_Pembayaran;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PembayaranController extends Controller
{
    /**
     * Index the form for creating a new resource.
     * @param int $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|object
     */
    public function index()
    {
        $kode_user = User::with('client')->find(Auth::id())->kode_user;

        $validasi = Pembayaran::with('pin.tukang.user', 'pin.penawaran.komponen', 'transaksi_pembayaran', 'pin.pengajuan')->whereHas('pin.pengajuan', function ($query) {
            $query->where('kode_client', Auth::id());
        })->orderByDesc('created_at')->get();

        return (new PembayaranResourceController($validasi))->response()->setStatusCode(200);
    }

    /**
     * Index the form for creating a new resource.
     * @param int $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|object
     */
    public function tagihan()
    {
        $kode_user = User::with('client')->find(Auth::id())->kode_user;

        $validasi = Pembayaran::where([['kode_status', '!=', 'P03']])->with('pin', 'pin.penawaran', 'transaksi_pembayaran')->whereHas('pin.pengajuan', function ($query) {
            $query->where('kode_client', Auth::id());
        })->get();

        return (new PembayaranResourceController($validasi))->response()->setStatusCode(200);
    }

    /**
     * Show the form for creating a new resource.
     * @param int $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|object
     */
    public function show(int $id)
    {
        $kode_user = User::with('client')->find(Auth::id())->kode_user;

        $validasi = Pembayaran::with('pin', 'pin.pengajuan', 'pin.penawaran', 'transaksi_pembayaran')->find($id);

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
            if ($validasi->kode_status == "P01" || $validasi->kode_status == "P01A") {
                if ($request->hasfile('path_transaksi')) {
                    $file = $request->file('path_transaksi');
                    $path = null;
                    if ($file->isValid()) {
                        $path = $file->store('images/pembayaran', 'public');
                        $path = substr($path, 6);
                        $path = "storage/images" . $path;
                    }

                    if (!$request->has('note_transaksi')) {
                        $request['note_transaksi'] = "---";
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

    /**
     * Batal the form for creating a new resource.
     * @param int $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|object
     */
    public function cancel(int $id)
    {
        if (!Pembayaran::whereId($id)->exists()){
            return (new PembayaranResourceController(['error' => 'Pembayaran tidak ditemukan !!!']))->response()->setStatusCode(404);
        }

        DB::transaction(function () use ($id){
           $pembayaran = Pembayaran::with('pin')->whereId($id)->first();
           Pin::whereId($pembayaran->pin->id)->update(['status' => 'N01']);
           $pembayaran->delete();
        });

        return (new PembayaranResourceController(['status'=>true, 'message'=>'berhasil melakukan pembatalan pembayaran, proses dikembalikan ke proses negosiasi.']))->response()->setStatusCode(200);
    }
}
