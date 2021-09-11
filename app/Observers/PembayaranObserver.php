<?php

namespace App\Observers;

use App\Events\PembayaranEventController;
use App\Models\Pembayaran;
use App\Models\Project;

class PembayaranObserver
{
    /**
     * Handle the User "created" event.
     *
     * @param \App\Models\Pembayaran $pembayaran
     * @return void
     */
    public function created(Pembayaran $pembayaran)
    {
        $this->notificationHandling($pembayaran, 'created');
    }

    /**
     * Handle the User "updated" event.
     *
     * @param \App\Models\Pembayaran $pembayaran
     * @return void
     */
    public function updated(Pembayaran $pembayaran)
    {
        if ($pembayaran->kode_status == 'P03'){
            $project = new Project();
            $project->kode_pembayaran = $pembayaran->id;
            $project->kode_status = "ON01";
            $project->save();
        }
        $this->notificationHandling($pembayaran, 'updated');
    }

    private function notificationHandling(Pembayaran $pembayaran, string $action)
    {
        $data = Pembayaran::with('pin.pengajuan.client.user')->whereId($pembayaran->id)->first();
        switch ($action) {
            case 'created':
                //deep_id == pembayaran
                createNotification(
                    $data->pin->pengajuan->kode_client,
                    'Pembayaran',
                    'Tagihan untuk proyek anda.',
                    $data->nama_proyek,
                    $data->id,
                    'client',
                    'add',
                    PembayaranEventController::eventCreated());
                break;
            case 'updated':
                //deep_id == pembayaran
                if ($data->kode_status == "P01B") {
                    createNotification(
                        0,
                        'Pembayaran',
                        'Pembayaran untuk proyek '.$data->pin->pengajuan->nama_proyek.' telah dibayar oleh '.$data->pin->pengajuan->client->user->name.' !!!',
                        $data->nama_proyek,
                        $data->id,
                        'admin',
                        'add',
                        PembayaranEventController::eventCreated());
                }
                //deep_id == pembayaran
                if ($data->kode_status == "P01A") {
                    createNotification(
                        $data->pin->pengajuan->kode_client,
                        'Pembayaran',
                        'Pembayaran untuk proyek '.$data->pin->pengajuan->nama_proyek.' telah ditolak.',
                        $data->nama_proyek,
                        $data->id,
                        'client',
                        'update',
                        PembayaranEventController::eventCreated());
                }
                //deep_id == pembayaran
                if ($data->kode_status == "P03") {
                    createNotification(
                        $data->pin->pengajuan->kode_client,
                        'Pembayaran',
                        'Pembayaran untuk proyek '.$data->pin->pengajuan->nama_proyek.' telah berhasil.',
                        $data->pin->pengajuan->nama_proyek,
                        $data->id,
                        'client',
                        'update',
                        PembayaranEventController::eventCreated());
                    createNotification(
                        $data->pin->kode_tukang,
                        'Pembayaran',
                        'Klien telah menyelesaikan pembayaran untuk proyek '.$data->pin->pengajuan->nama_proyek.'. Proyek sudah boleh dimulai !!!',
                        $data->pin->pengajuan->nama_proyek,
                        $data->id,
                        'tukang',
                        'update',
                        PembayaranEventController::eventCreated());
                }

                //deep_id == pembayaran
                if ($data->kode_status == "P02") {
                    createNotification(
                        $data->pin->kode_tukang,
                        'Pembayaran',
                        'Proyek dibatalkan, karena klien membatalkan pembayaran proyek '.$data->pin->pengajuan->nama_proyek.'.',
                        $data->nama_proyek,
                        $data->id,
                        'tukang',
                        'cancel',
                        PembayaranEventController::eventCreated());
                }
                break;
        }
    }
}
