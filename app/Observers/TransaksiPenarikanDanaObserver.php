<?php

namespace App\Observers;

use App\Events\PenarikanDanaEventController;
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
       if ($transaksi->kode_status == "PN05"){
           $update = PenarikanDana::find($transaksi->kode_penarikan);
           $per = Persentase_Penarikan::find($transaksi->kode_persentase_penarikan);
           $pen = ($update->total_dana * ($per->value/100));
           $update->persentase_penarikan = $update->persentase_penarikan + $per->value;
           $update->penarikan = $update->penarikan + $pen;
           $update->sisa_penarikan = $update->sisa_penarikan - $pen;
           $update->save();
       }
    }

    private function notificationHandling(Transaksi_Penarikan $transaksi, String $action)
    {
        $data = $transaksi::with('penarikan_dana.project.pembayaran.pin.pengajuan', 'penarikan_dana.project.pembayaran.pin.tukang.user')->whereId($transaksi->id)->first();
        switch ($action){
            case 'updated':
                //deep_id == penarikan_dana
                if ($data->kode_status == "PN01") {
                    createNotification(
                        $data->penarikan_dana->project->pembayaran->pin->pengajuan->kode_client,
                        'Penarikan Dana',
                        'Tukang ingin melakukan penarikan dana, mohon konfirmasi segera !',
                        $data->penarikan_dana->project->pembayaran->pin->pengajuan->nama_proyek,
                        $data->penarikan_dana->id,
                        'client',
                        'add',
                        PenarikanDanaEventController::eventCreated());
                }
                //deep_id == penarikan_dana
                if ($data->kode_status == "PN02") {
                    createNotification(
                        $data->penarikan_dana->project->pembayaran->pin->kode_tukang,
                        'Penarikan Dana',
                        'Klien menolak penarikan dana anda !',
                        $data->penarikan_dana->project->pembayaran->pin->pengajuan->nama_proyek,
                        $data->penarikan_dana->id,
                        'tukang',
                        'cencel',
                        PenarikanDanaEventController::eventCreated());
                }
                //deep_id == penarikan_dana
                if ($data->kode_status == "PN03") {
                    createNotification(
                        $data->penarikan_dana->project->pembayaran->pin->kode_tukang,
                        'Penarikan Dana',
                        'Klien menyetujui penarikan dana anda !',
                        $data->penarikan_dana->project->pembayaran->pin->pengajuan->nama_proyek,
                        $data->penarikan_dana->id,
                        'tukang',
                        'update',
                        PenarikanDanaEventController::eventCreated());
                    createNotification(
                        0,
                        'Penarikan Dana',
                        'Tukang '.$data->penarikan_dana->project->pembayaran->pin->tukang->user->name.' ingin melakukan penarikan dana !',
                        $data->penarikan_dana->project->pembayaran->pin->pengajuan->nama_proyek,
                        $data->penarikan_dana->id,
                        'admin',
                        'add',
                        PenarikanDanaEventController::eventCreated());
                }
                //deep_id == penarikan_dana
                if ($data->kode_status == "PN04") {
                    createNotification(
                        $data->penarikan_dana->project->pembayaran->pin->kode_tukang,
                        'Penarikan Dana',
                        'Admin menolak penarikan dana anda !',
                        $data->penarikan_dana->project->pembayaran->pin->pengajuan->nama_proyek,
                        $data->penarikan_dana->id,
                        'tukang',
                        'cancel',
                        PenarikanDanaEventController::eventCreated());
                }
                //deep_id == penarikan_dana
                if ($data->kode_status == "PN05") {
                    createNotification(
                        $data->penarikan_dana->project->pembayaran->pin->kode_tukang,
                        'Penarikan Dana',
                        'Admin telah mentransfer penarikan dana anda !',
                        $data->penarikan_dana->project->pembayaran->pin->pengajuan->nama_proyek,
                        $data->penarikan_dana->id,
                        'tukang',
                        'update',
                        PenarikanDanaEventController::eventCreated());
                }
                break;
        }
    }
}
