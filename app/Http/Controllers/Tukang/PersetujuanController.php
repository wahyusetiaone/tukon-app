<?php

namespace App\Http\Controllers\Tukang;

use App\Http\Controllers\Controller;
use App\Http\Resources\PersetujuanResourceController;
use App\Models\Pembayaran;
use App\Models\Penawaran;
use App\Models\Pin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PersetujuanController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param int $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|object
     */
    public function index(int $id)
    {
        $penawaran = Penawaran::with('pin', 'pin.pengajuan')->where('id', $id)->first();

        if ($penawaran->pin->status == "D01A") {
            if ($penawaran->pin->status == "D02") {
                $pembayaran = Pembayaran::find($penawaran->pin->id)->first();
                return (new PersetujuanResourceController(['status' => true, 'message' => "Sepertinya anda telah melakukan persetujuan.", 'kode_pembayaran' => $pembayaran->id]))->response()->setStatusCode(200);
            } else {
                $data = Pin::find($penawaran->pin->id);
                $data->update(['status' => 'D02']);
                return (new PersetujuanResourceController(['update_status' => $data]))->response()->setStatusCode(200);
            }
        } else {
            return (new PersetujuanResourceController(['error' => "Tidak bisa melakukan persetujuan projek karena klien belum melakukan persetujuan tehadap penawaran anda!!"]))->response()->setStatusCode(401);
        }
    }

/**
 * Show the form for creating a new resource.
 *
 * @return \Illuminate\Http\Response
 */
public
function create()
{
    //
}

/**
 * Store a newly created resource in storage.
 *
 * @param \Illuminate\Http\Request $request
 * @return \Illuminate\Http\Response
 */
public
function store(Request $request)
{
    //
}

/**
 * Display the specified resource.
 *
 * @param int $id
 * @return \Illuminate\Http\Response
 */
public
function show($id)
{
    //
}

/**
 * Show the form for editing the specified resource.
 *
 * @param int $id
 * @return \Illuminate\Http\Response
 */
public
function edit($id)
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
public
function update(Request $request, $id)
{
    //
}

/**
 * Remove the specified resource from storage.
 *
 * @param int $id
 * @return \Illuminate\Http\Response
 */
public
function destroy($id)
{
    //
}
}
