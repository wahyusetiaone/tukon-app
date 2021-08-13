<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\PenarikanDanaResourceController;
use App\Models\PenarikanDana;
use App\Models\Persentase_Penarikan;
use App\Models\Transaksi_Penarikan;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PenarikanDanaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|object
     */
    public function index()
    {
        try {
            $penarikan = PenarikanDana::with('project')->whereHas('project.pembayaran.pin', function ($query) {
                $query->where('kode_tukang', Auth::id());
            })->get();
            return (new PenarikanDanaResourceController(['data' => $penarikan]))->response()->setStatusCode(200);
        } catch (ModelNotFoundException $ee) {
            return (new PenarikanDanaResourceController(['error' => 'Item tidak ditemukan.']))->response()->setStatusCode(401);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|object
     */
    public function indexClient(int $id)
    {
        try {
            $penarikan = PenarikanDana::with('transaksi_penarikan','transaksi_penarikan.persentase')->whereHas('project.pembayaran.pin.pengajuan', function ($query) {
                $query->where('kode_client', Auth::id());
            })->where('id', $id)->get();
            return (new PenarikanDanaResourceController(['data' => $penarikan]))->response()->setStatusCode(200);
        } catch (ModelNotFoundException $ee) {
            return (new PenarikanDanaResourceController(['error' => 'Item tidak ditemukan.']))->response()->setStatusCode(401);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|object
     */
    public function indexTukang(int $id)
    {
        try {
            $penarikan = PenarikanDana::with('transaksi_penarikan','transaksi_penarikan.persentase')->whereHas('project.pembayaran.pin', function ($query) {
                $query->where('kode_tukang', Auth::id());
            })->where('id', $id)->get();
            return (new PenarikanDanaResourceController(['data' => $penarikan]))->response()->setStatusCode(200);
        } catch (ModelNotFoundException $ee) {
            return (new PenarikanDanaResourceController(['error' => 'Item tidak ditemukan.']))->response()->setStatusCode(401);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|object
     */
    public function create(int $id)
    {
        try {
            $penarikan = PenarikanDana::with('project', 'limitasi_penarikan')->whereHas('project.pembayaran.pin', function ($query) {
                $query->where('kode_tukang', Auth::id());
            })->where('id', $id)->first();
            if (!isset($penarikan)) {
                return (new PenarikanDanaResourceController(['error' => 'Anda tidak memiliki akses terhadap item ini.']))->response()->setStatusCode(401);
            }
            //6 adalah kode pembayaran 100%
            $avaliable = Persentase_Penarikan::all()->except(6)->keyBy('value');

            if ($penarikan->kode_limitasi == 2) {
                $avaliable = Persentase_Penarikan::all()->keyBy('value');
            }

            if ($penarikan->persentase_penarikan > 25) {
                $avaliable->forget(25);
            }
            if ($penarikan->persentase_penarikan > 30) {
                $avaliable->forget(20);
            }
            if ($penarikan->persentase_penarikan > 35) {
                $avaliable->forget(15);
            }
            if ($penarikan->persentase_penarikan > 40) {
                $avaliable->forget(10);
            }
            if ($penarikan->persentase_penarikan > 45) {
                $avaliable->forget(5);
            }
            return (new PenarikanDanaResourceController(['data' => $avaliable]))->response()->setStatusCode(200);
        } catch (ModelNotFoundException $ee) {
            return (new PenarikanDanaResourceController(['error' => 'Item tidak ditemukan atau anda tidak memiliki akses terhadap item ini.']))->response()->setStatusCode(401);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param int $id
     * @param int $persen
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|object
     */
    public function store(int $id, int $persen)
    {
        try {
            $penarikan = PenarikanDana::with('project', 'limitasi_penarikan')->whereHas('project.pembayaran.pin', function ($query) {
                $query->where('kode_tukang', Auth::id());
            })->where('id', $id)->first();

            if ($penarikan->persentase_penarikan == $penarikan->limitasi_penarikan->value) {
                if ($penarikan->kode_limitasi == 1) {
                    return (new PenarikanDanaResourceController(['error' => 'Anda telah mencapai ' . $penarikan->limitasi_penarikan->name . ' !!!']))->response()->setStatusCode(200);
                }
                return (new PenarikanDanaResourceController(['error' => 'Anda telah mencairkan dana ini secara penuh !!!']))->response()->setStatusCode(200);
            }

            //6 adalah kode pembayaran 100%
            $avaliable = Persentase_Penarikan::all()->pluck('value')->toArray();
            if ($penarikan->kode_limitasi == 1) {
                unset($avaliable[5]);
            }
            if ($penarikan->persentase_penarikan > 25) {
                unset($avaliable[4]);
            }
            if ($penarikan->persentase_penarikan > 30) {
                unset($avaliable[3]);
            }
            if ($penarikan->persentase_penarikan > 35) {
                unset($avaliable[2]);
            }
            if ($penarikan->persentase_penarikan > 40) {
                unset($avaliable[1]);
            }
            if ($penarikan->persentase_penarikan > 45) {
                unset($avaliable[0]);
            }

            if ($penarikan->persentase_penarikan < $penarikan->limitasi_penarikan->value) {
                if (!in_array($persen, $avaliable)) {
                    return (new PenarikanDanaResourceController(['error' => 'Tidak dapat melakukan penarikan dengan persentase '.$persen.'% !!!']))->response()->setStatusCode(200);
                }

                DB::transaction(function () use ($penarikan, $persen){
                    $pen = ($penarikan->total_dana * ($persen/100));
                    $per = Persentase_Penarikan::where('value', $persen)->first();
                    $transaksi = new Transaksi_Penarikan();
                    $transaksi->kode_penarikan = $penarikan->id;
                    $transaksi->kode_persentase_penarikan = $per->id;
                    $transaksi->penarikan = $pen;
                    $transaksi->kode_status = "PN01";
                    $transaksi->save();
                });

                return (new PenarikanDanaResourceController(['success' => 'Oke']))->response()->setStatusCode(200);
            }
            return (new PenarikanDanaResourceController(['error' => 'Anda tidak dapat mencairkan sebesar ' . $persen . '% dikarenakan limit anda saat ini adalah ' . $penarikan->limitasi_penarikan->value . '% !!!']))->response()->setStatusCode(200);
        } catch (ModelNotFoundException $ee) {
            return (new PenarikanDanaResourceController(['error' => 'Item tidak ditemukan.']))->response()->setStatusCode(401);
        }
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
     * @param int $id
     * @param int $transaksi
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|object
     */
    public function terima(int $id, int $transaksi)
    {
        $penarikan = PenarikanDana::with('project', 'limitasi_penarikan')->whereHas('project.pembayaran.pin.pengajuan', function ($query) {
            $query->where('kode_client', Auth::id());
        })->where('id', $id)->exists();

        if ($penarikan){
            if (!Transaksi_Penarikan::where('id',$transaksi)->exists()) {
                return (new PenarikanDanaResourceController(['error' => 'Data Transaksi Penarikan tidak ditemukan !!!']))->response()->setStatusCode(200);
            }
            $transaksi = Transaksi_Penarikan::find($transaksi);
            if ($transaksi->kode_status == "PN02"){
                return (new PenarikanDanaResourceController(['data' => 'Anda telah menolak penarikan ini !!!']))->response()->setStatusCode(200);
            }
            if ($transaksi->kode_status == "PN02"){
                return (new PenarikanDanaResourceController(['data' => 'Anda telah menolak penarikan ini !!!']))->response()->setStatusCode(200);
            }
            if ($transaksi->kode_status == "PN03" || $transaksi->kode_status == "PN04"){
                return (new PenarikanDanaResourceController(['data' => 'Anda telah menyetujui penarikan ini !!!']))->response()->setStatusCode(200);
            }
            if ($transaksi->kode_status == "PN01"){
                $transaksi->update(['kode_status' => 'PN03']);
                return (new PenarikanDanaResourceController(['data' => 'Sekses menyetujui penarikan !!!']))->response()->setStatusCode(200);
            }
        }
        return (new PenarikanDanaResourceController(['error' => 'Data Penarikan tidak ditemukan !!!']))->response()->setStatusCode(200);
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
        $penarikan = PenarikanDana::with('project', 'limitasi_penarikan')->whereHas('project.pembayaran.pin.pengajuan', function ($query) {
            $query->where('kode_client', Auth::id());
        })->where('id', $id)->exists();

        if ($penarikan){
            if (!Transaksi_Penarikan::where('id',$transaksi)->exists()){
                return (new PenarikanDanaResourceController(['error' => 'Data Transaksi Penarikan tidak ditemukan !!!']))->response()->setStatusCode(200);
            }
            $transaksi = Transaksi_Penarikan::find($transaksi);
            if ($transaksi->kode_status == "PN02"){
                return (new PenarikanDanaResourceController(['data' => 'Anda telah menolak penarikan ini !!!']))->response()->setStatusCode(200);
            }
            if ($transaksi->kode_status == "PN02"){
                return (new PenarikanDanaResourceController(['data' => 'Anda telah menolak penarikan ini !!!']))->response()->setStatusCode(200);
            }
            if ($transaksi->kode_status == "PN03" || $transaksi->kode_status == "PN04"){
                return (new PenarikanDanaResourceController(['data' => 'Anda telah menyetujui penarikan ini !!!']))->response()->setStatusCode(200);
            }
            if ($transaksi->kode_status == "PN01"){
                $transaksi->kode_status = "PN02";
                $transaksi->save();
                return (new PenarikanDanaResourceController(['data' => 'Sekses menolak penarikan !!!']))->response()->setStatusCode(200);
            }
        }
        return (new PenarikanDanaResourceController(['error' => 'Data Penarikan tidak ditemukan !!!']))->response()->setStatusCode(200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
