<?php

namespace App\Observers;

use App\Models\PengembalianDana;
use App\Models\Transaksi_Pengembalian;

class TransaksiPengembalianDanaObserver
{
    /**
     * Handle the User "created" event.
     *
     * @param  \App\Models\Transaksi_Pengembalian  $tr
     * @return void
     */
    public function created(Transaksi_Pengembalian $tr)
    {
        PengembalianDana::find($tr->kode_pengembalian_dana)->update(['kode_status' => 'PM02']);
    }

    /**
     * Handle the TransaksiPembayaran "updated" event.
     *
     * @param \App\Models\Transaksi_Pengembalian $tr
     * @return void
     */
    public function updated(Transaksi_Pengembalian $tr)
    {
        if ($tr->kode_status == "TP02"){
            PengembalianDana::find($tr->kode_pengembalian_dana)->update(['kode_status' => 'PM01']);
        }
        if ($tr->kode_status == "TP03"){
            PengembalianDana::find($tr->kode_pengembalian_dana)->update(['kode_status' => 'PM03']);
        }
    }
}
