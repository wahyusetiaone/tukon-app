<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Resources\PersetujuanResourceController;
use App\Models\Pembayaran;
use App\Models\Penawaran;
use App\Models\Pin;
use App\Models\Revisi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PersetujuanController extends Controller
{
    /**
     * Show the form for updating a new resource from client.
     *
     * @param int $kode
     * @param int $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|object
     */
    public function accept_client(Request $request, int $kode, int $id)
    {
        try {
            $penawaran = Penawaran::with('pin', 'pin.pengajuan')->where('id', $id)->first();

            if ($kode == $penawaran->pin->pengajuan->kode_client) {

                if (!is_null($penawaran->pin->kode_penawaran)) {

                    $data = Pin::find($penawaran->pin->id);
                    $data->update(['status' => 'D01A']);
                    return (new PersetujuanResourceController(['update_status' => 1]))->response()->setStatusCode(200);
                } else {
                    return (new PersetujuanResourceController(['update_status' => 0, 'error' => "Tidak bisa melakukan persetujuan projek karena tukang belum melakukan penawaran!!"]))->response()->setStatusCode(401);
                }
            } else {
                return (new PersetujuanResourceController(['update_status' => 0, 'error' => 'Mohon maaf, anda tidak mendapat akses untuk mengubah record ini !!!']))->response()->setStatusCode(401);
            }
        } catch (\Exception $ee) {
            return (new PersetujuanResourceController(['update_status' => 0, 'error' => 'ID penawaran tidak terdaftar pada sistem !!!']))->response()->setStatusCode(401);
        }
    }

    /**
     * Show the form for updating a new resource from client.
     *
     * @param int $kode
     * @param int $id
     * @param String $note
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|object
     */
    public function revisi_client(int $kode,int $id, string $note)
    {
        $penawaran = Penawaran::with('pin', 'pin.pengajuan')->where('id', $id)->first();

        if ($kode == $penawaran->pin->pengajuan->kode_client) {

            if (!is_null($penawaran->pin->kode_penawaran)) {
                if ($penawaran->kode_status == "T02") {
                    $revisi = new Revisi();
                    $revisi->kode_penawaran = $id;
                    $revisi->note = $note;
                    $revisi->save();
                    return (new PersetujuanResourceController(['update_status' => 1]))->response()->setStatusCode(200);
                }
                return (new PersetujuanResourceController(['update_status' => 0, 'error' => "Tidak bisa melakukan permintaan revisi penawaran projek karena revisi sebelumnya blm di tanggapi oleh tukang!!"]))->response()->setStatusCode(200);
            } else {
                return (new PersetujuanResourceController(['update_status' => 0, 'error' => "Tidak bisa melakukan permintaan revisi penawaran projek karena tukang belum melakukan penawaran!!"]))->response()->setStatusCode(401);
            }
        } else {

            return (new PersetujuanResourceController(['update_status' => 0, 'error' => 'Mohon maaf, anda tidak mendapat akses untuk mengubah record ini !!!']))->response()->setStatusCode(401);
        }
    }
}
