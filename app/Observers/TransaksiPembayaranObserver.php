<?php

namespace App\Observers;

use App\Models\Pembayaran;
use App\Models\Progress;
use App\Models\Project;
use App\Models\Transaksi_Pembayaran;

class TransaksiPembayaranObserver
{
    /**
     * Handle the TransaksiPembayaran "created" event.
     *
     * @param \App\Models\Transaksi_Pembayaran $transaksi
     * @return void
     */
    public function created(Transaksi_Pembayaran $transaksi)
    {
        if ($transaksi->status_transaksi == "A01") {
            Pembayaran::whereId($transaksi->kode_pembayaran)->update(["kode_status" => "P01B"]);
        }
    }

    /**
     * Handle the TransaksiPembayaran "updated" event.
     *
     * @param \App\Models\Transaksi_Pembayaran $transaksi
     * @return void
     */
    public function updated(Transaksi_Pembayaran $transaksi)
    {
        if ($transaksi->status_transaksi == "A02") {
            Pembayaran::whereId($transaksi->kode_pembayaran)->update(["kode_status" => "P01A"]);
        }

        if ($transaksi->status_transaksi == "A03") {
            Pembayaran::whereId($transaksi->kode_pembayaran)->update(["kode_status" => "P03"]);
            $project = new Project();
            $project->kode_pembayaran = $transaksi->kode_pembayaran;
            $project->kode_status = "ON01";
            $project->save();
        }
    }
}
