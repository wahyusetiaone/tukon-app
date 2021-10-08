<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Resources\PersetujuanResourceController;
use App\Models\NegoPenawaran;
use App\Models\Pembayaran;
use App\Models\Penawaran;
use App\Models\Pengajuan;
use App\Models\Pin;
use App\Models\Revisi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

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
                    $data->update(['status' => 'D02']);
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
                    $data->update(['status' => 'D02']);

                    Alert::success('Succesfully Saved', 'Berhasil menyetujui penawaran!');
                    return redirect()->back();
                } else {
                    Alert::error('Error', 'Tidak bisa melakukan persetujuan projek karena tukang belum melakukan penawaran!!');
                    return redirect()->back();
                }
            } else {
                Alert::error('Error', 'Mohon maaf, anda tidak mendapat akses untuk mengubah record ini !!!');
                return redirect()->back();
            }
        } catch (\Exception $ee) {
            Alert::error('Error', 'ID penawaran tidak terdaftar pada sistem !!!');
            return redirect()->back();
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
                    return (new PersetujuanResourceController(['update_status' => 1]))->response()->setStatusCode(200);
                }
                return (new PersetujuanResourceController(['update_status' => 0, 'error' => "Tidak bisa melakukan permintaan nego penawaran projek karena revisi sebelumnya blm di tanggapi oleh tukang!!"]))->response()->setStatusCode(200);
            } else {
                return (new PersetujuanResourceController(['update_status' => 0, 'error' => "Tidak bisa melakukan permintaan nego penawaran projek karena tukang belum melakukan penawaran!!"]))->response()->setStatusCode(401);
            }
        } else {

            return (new PersetujuanResourceController(['update_status' => 0, 'error' => 'Mohon maaf, anda tidak mendapat akses untuk mengubah record ini !!!']))->response()->setStatusCode(401);
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
            Alert::error('Error', 'Penawaran tidak ditemukan!');
            return redirect()->back();
        }
        $penawaran = Pin::whereHas('penawaran', function ($q) use ($id) {
            $q->whereId($id);
        })->first();
        $penawaran->update(['status' => 'B01']);

        Alert::success('Succesfully Saved', 'Berhasil menolak penawaran!');
        return redirect()->back();
    }
}
