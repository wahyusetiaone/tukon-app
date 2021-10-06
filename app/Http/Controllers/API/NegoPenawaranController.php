<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\NegoPenawaranResourceController;
use App\Models\NegoPenawaran;
use App\Models\Penawaran;
use App\Models\Pin;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class NegoPenawaranController extends Controller
{
    /**
     * Show the form for updating a new resource from client.
     *
     * @param int $kode
     * @param int $id
     * @param String $note
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|object
     */
    public function nego_client(int $kode, int $id, int $harganego)
    {
        $penawaran = Penawaran::with('pin', 'pin.pengajuan')->where('id', $id)->first();

        if ($kode == $penawaran->pin->pengajuan->kode_client) {

            if (!is_null($penawaran->pin->kode_penawaran)) {
                if ($penawaran->kode_status == "T02") {
                    $nego = new NegoPenawaran();
                    $nego->kode_penawaran = $id;
                    $nego->harga_nego = $harganego;
                    $nego->save();
                    return (new NegoPenawaranResourceController(['update_status' => 1]))->response()->setStatusCode(200);
                }
                return (new NegoPenawaranResourceController(['update_status' => 0, 'error' => "Tidak bisa melakukan permintaan nego penawaran projek karena revisi sebelumnya blm di tanggapi oleh tukang!!"]))->response()->setStatusCode(200);
            } else {
                return (new NegoPenawaranResourceController(['update_status' => 0, 'error' => "Tidak bisa melakukan permintaan nego penawaran projek karena tukang belum melakukan penawaran!!"]))->response()->setStatusCode(401);
            }
        } else {

            return (new NegoPenawaranResourceController(['update_status' => 0, 'error' => 'Mohon maaf, anda tidak mendapat akses untuk mengubah record ini !!!']))->response()->setStatusCode(401);
        }
    }

    /**
     * Show the form for updating a new resource from client.
     *
     * @param int $kode
     * @param int $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|object
     */
    public function accept_nego_client(Request $request, int $kode, int $id)
    {
        try {
            $penawaran = Penawaran::with('pin', 'nego', 'pin.pengajuan')->where('id', $id)->first();

            if ($kode == $penawaran->pin->pengajuan->kode_client) {

                if (!is_null($penawaran->pin->kode_penawaran)) {

                    $data = Pin::find($penawaran->pin->id);
                    if ($request->input('harga') == 'new') {
                        $harga = $penawaran->nego->harga_nego;
                        $harga_total = $harga + (($harga * $penawaran->keuntungan) / 100);
                        $penawaran->update(['harga' => $harga, 'harga_total' => $harga_total]);
                    }
                    $data->update(['status' => 'D01A']);
                    return (new NegoPenawaranResourceController(['data' => 'Berhasil menyetujui penawaran!']))->response()->setStatusCode(200);
                } else {
                    return (new NegoPenawaranResourceController(['error' => 'Tidak bisa melakukan persetujuan projek karena tukang belum melakukan penawaran!']))->response()->setStatusCode(401);
                }
            } else {
                return (new NegoPenawaranResourceController(['error' => 'Mohon maaf, anda tidak mendapat akses untuk mengubah record ini !']))->response()->setStatusCode(401);
            }
        } catch (\Exception $ee) {
            return (new NegoPenawaranResourceController(['error' => 'ID penawaran tidak terdaftar pada sistem !']))->response()->setStatusCode(401);
        }
    }

    /**
     * Show the form for updating a new resource from client.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|object
     */
    public function batal_client(int $id)
    {
        if (!Penawaran::whereId($id)->exists()) {
            return (new NegoPenawaranResourceController(['error' => 'Penawaran tidak ditemukan!']))->response()->setStatusCode(401);
        }
        $penawaran = Pin::whereHas('penawaran', function ($q) use ($id) {
            $q->whereId($id);
        })->first();
        $penawaran->update(['status' => 'B01']);

        return (new NegoPenawaranResourceController(['data' => 'Berhasil menolak penawaran!']))->response()->setStatusCode(200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|object
     */
    public function tolak_nego(Request $request, $id)
    {
        if (!Penawaran::whereId($id)->exists()){
            return (new NegoPenawaranResourceController(['error' => 'Penawaran tidak ditemukan!']))->response()->setStatusCode(401);
        }

        try {
            $data = NegoPenawaran::whereId($request->input('nego_id'))->first();
            $data->disetujui = false;
            $data->save();
            return (new NegoPenawaranResourceController(['data' => 'Berhasil menolak harga Nego Penawaran!']))->response()->setStatusCode(200);
        } catch (ModelNotFoundException $e) {
            return (new NegoPenawaranResourceController(['error' => 'Gagal menolak harga Nego Penawaran!']))->response()->setStatusCode(401);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|object
     */
    public function setuju_nego(Request $request, $id)
    {
        if (!Penawaran::whereId($id)->exists()){
            return (new NegoPenawaranResourceController(['error' => 'Penawaran tidak ditemukan!']))->response()->setStatusCode(401);

        }
        try {
            $data = NegoPenawaran::whereId($request->input('nego_id'))->first();
            $data->disetujui = true;
            $data->save();
            return (new NegoPenawaranResourceController(['data' => 'Berhasil menyetujui harga Nego Penawaran!']))->response()->setStatusCode(200);
        } catch (ModelNotFoundException $e) {
            return (new NegoPenawaranResourceController(['error' => 'Gagal menyetujui harga Nego Penawaran!']))->response()->setStatusCode(401);

        }
    }
}
