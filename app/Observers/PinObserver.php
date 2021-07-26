<?php

namespace App\Observers;

use App\Models\History_Penawaran;
use App\Models\Pembayaran;
use App\Models\Penawaran;
use App\Models\Pin;
use App\Models\Revisi;
use Illuminate\Support\Facades\Log;

class PinObserver
{

    /**
     * Handle the User "updating" event.
     *
     * @param \App\Models\Pin $pin
     * @return void
     */
    public function updated(Pin $pin)
    {
        if ($pin->status == "D01A") {
            $pins = Pin::where([
                ['id', '!=', $pin->id],
                ['kode_pengajuan', '=', $pin->kode_pengajuan],
            ])->get();
            foreach ($pins as $p) {
                Pin::whereId($p->id)->update(['status' => 'B04']);
            }
        }
        if ($pin->status == "D02") {
            $dat = Pin::with('penawaran')->find($pin->id)->first();
            $keuntungan = ($dat->penawaran->harga_total * $dat->penawaran->keuntungan) / 100;
            $tharga = $dat->penawaran->harga_total + $keuntungan;
            $pembayaran = new Pembayaran();
            $pembayaran->kode_penawaran = $pin->id;
            $pembayaran->total_tagihan = $tharga;
            $pembayaran->save();
        }

    }
}
