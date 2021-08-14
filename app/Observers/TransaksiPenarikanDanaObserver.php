<?php

namespace App\Observers;

use App\Models\PenarikanDana;
use App\Models\Persentase_Penarikan;
use App\Models\Transaksi_Penarikan;

class TransaksiPenarikanDanaObserver
{
    /**
     * Handle the TransaksiPembayaran "updated" event.
     *
     * @param \App\Models\Transaksi_Penarikan $transaksi
     * @return void
     */
    public function updated(Transaksi_Penarikan $transaksi)
    {
       if ($transaksi->kode_status == "PN03"){
           $update = PenarikanDana::find($transaksi->kode_penarikan);
           $per = Persentase_Penarikan::find($transaksi->kode_persentase_penarikan);
           $pen = ($update->total_dana * ($per->value/100));
           $update->persentase_penarikan = $update->persentase_penarikan + $per->value;
           $update->penarikan = $update->penarikan + $pen;
           $update->sisa_penarikan = $update->sisa_penarikan - $pen;
           $update->save();
       }
    }
}
