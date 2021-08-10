<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\PenarikanDanaResourceController;
use App\Models\PenarikanDana;
use App\Models\Persentase_Penarikan;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
     * Show the form for creating a new resource.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|object
     */
    public function create(int $id)
    {
        try {
            $penarikan = PenarikanDana::with('project', 'limitasi')->whereHas('project.pembayaran.pin', function ($query) {
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

            if ($penarikan->persentase_penarikan < $penarikan->limitasi_penarikan->value) {
                if (!in_array($persen, $avaliable)) {
                    return (new PenarikanDanaResourceController(['error' => 'Tidak dapat melakukan penarikan dengan persentase '.$persen.'% !!!']))->response()->setStatusCode(200);
                }
                return (new PenarikanDanaResourceController(['success' => 'Oke']))->response()->setStatusCode(200);
            }
            return (new PenarikanDanaResourceController(['error' => 'Anda tidak dapat mencairkan sebesar ' . $persen . '% dikarenakan limit anda saat ini adalah ' . $penarikan->limitasi->value . '% !!!']))->response()->setStatusCode(200);
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
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
