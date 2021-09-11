<?php

namespace App\Observers;

use App\Events\PengembalianDanaEventController;
use App\Models\PengembalianDana;
use App\Models\Transaksi_Pengembalian;

class TransaksiPengembalianDanaObserver
{
    /**
     * Handle the User "created" event.
     *
     * @param \App\Models\Transaksi_Pengembalian $tr
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
        if ($tr->kode_status == "TP02") {
            PengembalianDana::find($tr->kode_pengembalian_dana)->update(['kode_status' => 'PM01']);
        }
        if ($tr->kode_status == "TP03") {
            PengembalianDana::find($tr->kode_pengembalian_dana)->update(['kode_status' => 'PM03']);
        }
    }

    private function notificationHandling(Transaksi_Pengembalian $tr, string $action)
    {
        $data = Transaksi_Pengembalian::with('pengembalian_dana.project.pembayaran.pin.pengajuan.client.user', 'pengembalian_dana.project.pembayaran.pin.tukang.user')->whereId($tr->id)->first();
        switch ($action) {
            case 'created':
                //deep_id == pengembalian_dana
                createNotification(
                    0,
                    'Pengembalian Dana',
                    'Pengajuan Pengembalian Dana Klien ' . $data->pengembalian_dana->project->pembayaran->pin->pengajuan->client->user . ' masuk. ',
                    $data->nama_proyek,
                    $data->id,
                    'admin',
                    'add',
                    PengembalianDanaEventController::eventCreated());
                break;
            case 'updated':
                //deep_id == pengembalian_dana
                if ($data->kode_status == "TP02") {
                    createNotification(
                        $data->pengembalian_dana->project->pembayaran->pin->pengajuan->kode_client,
                        'Pengembalian Dana',
                        'Pengembalian Dana anda ditolak oleh admin.',
                        $data->nama_proyek,
                        $data->id,
                        'client',
                        'cancel',
                        PengembalianDanaEventController::eventCreated());
                }
                //deep_id == pengembalian_dana
                if ($data->kode_status == "TP03") {
                    createNotification(
                        $data->pengembalian_dana->project->pembayaran->pin->pengajuan->kode_client,
                        'Pengembalian Dana',
                        'Pengembalian Dana anda ditolak oleh admin.',
                        $data->nama_proyek,
                        $data->id,
                        'client',
                        'cancel',
                        PengembalianDanaEventController::eventCreated());
                }
                break;
        }
    }
}
