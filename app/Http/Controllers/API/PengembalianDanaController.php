<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\PengembalianDanaResourceController;
use App\Models\PengembalianDana;
use App\Models\Transaksi_Pengembalian;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
class PengembalianDanaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|object
     */
    public function index()
    {
        try {
            $pengembalian = PengembalianDana::with('transaksi')->whereHas('project.pembayaran.pin.pengajuan', function ($query) {
                $query->where('kode_client', Auth::id());
            })->paginate(10);
            return (new PengembalianDanaResourceController(['data' => $pengembalian]))->response()->setStatusCode(200);
        } catch (ModelNotFoundException $ee) {
            return (new PengembalianDanaResourceController(['error' => 'Item tidak ditemukan.']))->response()->setStatusCode(401);
        }
    }

    /**
     * Show the form for creating a new resource.
     * @param int $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|object
     */
    public function ajukan(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [
            'nomor_rekening' => 'string|required',
            'atas_nama_rekening' => 'string|required',
            'bank' => 'string|required',
        ]);

        if ($validator->fails()) {
            return (new PengembalianDanaResourceController(['error' => $validator->errors()]))->response()->setStatusCode(401);
        }

        if (!PengembalianDana::find($id)->exists()){
            return (new PengembalianDanaResourceController(['error' => 'ID tidak ditemukan pada server !!!']))->response()->setStatusCode(401);
        }

        $validasi = PengembalianDana::with('project.pembayaran.pin.pengajuan')->find($id);

        if (Auth::id() == $validasi->project->pembayaran->pin->pengajuan->kode_client) {

            if ($validasi->kode_status == 'PM02'){
                return (new PengembalianDanaResourceController(['error' => 'Transaksi pengajuan Pengembalian Dana sebelumnya belum di respon oleh admin, anda tidak dapat melakukan pengajuan kembali. Mohon untuk menunggu respon dari admin, terimakasih.']))->response()->setStatusCode(401);
            }
            if ($validasi->kode_status == 'PM03'){
                return (new PengembalianDanaResourceController(['error' => 'Transaksi Pengembalian Dana telah berhasil. Anda tidak dapat mengajukan kembali.']))->response()->setStatusCode(401);
            }

            $tr = new Transaksi_Pengembalian();
            $tr->kode_pengembalian_dana = $validasi->id;
            $tr->nomor_rekening = $request->input('nomor_rekening');
            $tr->atas_nama_rekening = $request->input('atas_nama_rekening');
            $tr->bank = $request->input('bank');
            $tr->save();

            return (new PengembalianDanaResourceController(['success' => 'Transaksi Pengembalian Dana telah berhasil di ajukan, mohon menunggu konfirmasi pengembalian oleh admin selama 2x24jam tidak termasuk hari libur. Terimakasih.']))->response()->setStatusCode(200);
        }
        return (new PengembalianDanaResourceController(['error' => 'Tidak ada akses untuk merubah data ini !!!']))->response()->setStatusCode(401);

    }
}
