<?php

namespace App\Observers;

use App\Models\Pembayaran;
use App\Models\Pin;

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
        if ($pin->status == "D01A"){
            $pins = Pin::where([
                ['id', '!=', $pin->id],
                ['kode_pengajuan', '=', $pin->kode_pengajuan],
            ])->get();
            foreach ($pins as $p) {
                Pin::whereId($p->id)->update(['status' => 'B04']);
            }
        }
        if ($pin->status == "D02"){
            $pembayaran = new Pembayaran();
            $pembayaran->kode_penawaran = $pin->id;
            $pembayaran->save();
        }

    }
}
