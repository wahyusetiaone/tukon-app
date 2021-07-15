<?php

namespace App\Observers;

use App\Models\History_Penawaran;
use App\Models\Penawaran;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PenawaranObserver
{
    /**
     * Handle the User "updating" event.
     *
     * @param  \App\Models\Penawaran  $penawaran
     * @return void
     */
    public function updating(Penawaran $penawaran)
    {
        try {
            $penawaran = Penawaran::findOrFail($penawaran->id);

            $revisi = History_Penawaran::with('penawaran')->orderBy('created_at','desc')->first();
            $revisi = ($revisi->revisi + 1);
        }catch (ModelNotFoundException $ee){
            $revisi = 0;
        }
        $history = new History_Penawaran();
        $history->kode_penawaran = $penawaran->id;
        $history->kode_pin = $penawaran->kode_pin;
        $history->keuntungan = $penawaran->keuntungan;
        $history->harga_total = $penawaran->harga_total;
        $history->kode_status = $penawaran->kode_status;
        $history->revisi = $revisi;
        $history->save();
    }
}
