<?php

namespace App\Observers;

use App\Models\History_Penawaran;
use App\Models\Pembayaran;
use App\Models\Penawaran;
use App\Models\Pengajuan;
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
            $dat = Pin::with('penawaran')->where('id',$pin->id)->first();
            $pembayaran = new Pembayaran();
            $pembayaran->kode_pin = $pin->id;
            $pembayaran->total_tagihan = $dat->penawaran->harga_total;
            $pembayaran->save();
        }
        if ($pin->status == "B02"){
            $count = Pin::select('id')->where('kode_pengajuan', $pin->kode_pengajuan)->count();
            if ($count <= 1){
                Pengajuan::whereId($pin->kode_pengajuan)->update([ 'kode_status'=> 'T03' ]);
            }
        }


    }
}
