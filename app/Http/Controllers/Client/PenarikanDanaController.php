<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Resources\PenarikanDanaResourceController;
use App\Models\PenarikanDana;
use App\Models\Transaksi_Penarikan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PenarikanDanaController extends Controller
{
    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     * @param int $transaksi
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|object
     */
    public function terima(int $id, int $transaksi)
    {
        $penarikan = PenarikanDana::with('project', 'limitasi_penarikan','project.pembayaran.pin.pengajuan')->where('id', $id)->exists();

        if ($penarikan){
            if (!Transaksi_Penarikan::where('id',$transaksi)->exists()) {
                return (new PenarikanDanaResourceController(['status'=> false, 'error' => 'Data Transaksi Penarikan tidak ditemukan !!!']))->response()->setStatusCode(200);
            }
            $transaksi = Transaksi_Penarikan::find($transaksi);
            if ($transaksi->kode_status == "PN02"){
                return (new PenarikanDanaResourceController(['status'=> false, 'error' => 'Anda telah menolak penarikan ini !!!']))->response()->setStatusCode(200);
            }
            if ($transaksi->kode_status == "PN05"){
                return (new PenarikanDanaResourceController(['status'=> false, 'error' => 'Penarikan ini telah berhasil !!!']))->response()->setStatusCode(200);
            }
            if ($transaksi->kode_status == "PN03" || $transaksi->kode_status == "PN04"){
                return (new PenarikanDanaResourceController(['status'=> false, 'error' => 'Anda telah menyetujui penarikan ini !!!']))->response()->setStatusCode(200);
            }
            if ($transaksi->kode_status == "PN01"){
                $transaksi->update(['kode_status' => 'PN03']);
                return (new PenarikanDanaResourceController(['status'=> true, 'data' => 'Sekses menyetujui penarikan !!!']))->response()->setStatusCode(200);
            }
        }
        return (new PenarikanDanaResourceController(['status'=> false, 'error' => 'Data Penarikan tidak ditemukan !!!']))->response()->setStatusCode(200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     * @param int $transaksi
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|object
     */
    public function tolak(int $id, int $transaksi)
    {
        $penarikan = PenarikanDana::with('project', 'limitasi_penarikan','project.pembayaran.pin.pengajuan')->where('id', $id)->exists();

        if ($penarikan){
            if (!Transaksi_Penarikan::where('id',$transaksi)->exists()) {
                return (new PenarikanDanaResourceController(['status'=> false, 'error' => 'Data Transaksi Penarikan tidak ditemukan !!!']))->response()->setStatusCode(200);
            }
            $transaksi = Transaksi_Penarikan::find($transaksi);
            if ($transaksi->kode_status == "PN02"){
                return (new PenarikanDanaResourceController(['status'=> false, 'error' => 'Anda telah menolak penarikan ini !!!']))->response()->setStatusCode(200);
            }
            if ($transaksi->kode_status == "PN05"){
                return (new PenarikanDanaResourceController(['status'=> false, 'error' => 'Penarikan ini telah berhasil !!!']))->response()->setStatusCode(200);
            }
            if ($transaksi->kode_status == "PN03" || $transaksi->kode_status == "PN04"){
                return (new PenarikanDanaResourceController(['status'=> false, 'error' => 'Anda telah menyetujui penarikan ini !!!']))->response()->setStatusCode(200);
            }
            if ($transaksi->kode_status == "PN01"){
                $transaksi->kode_status = "PN02";
                $transaksi->save();
                return (new PenarikanDanaResourceController(['status'=> true, 'data' => 'Sekses menolak penarikan !!!']))->response()->setStatusCode(200);
            }
        }
        return (new PenarikanDanaResourceController(['status'=> false, 'error' => 'Data Penarikan tidak ditemukan !!!']))->response()->setStatusCode(200);
    }
}
