<?php

namespace App\Observers;

use App\Events\PengajuanEventController;
use App\Models\Pengajuan;
use App\Models\Pin;

class PengajuanObserver
{
    /**
     * Handle the User "updated" event.
     *
     * @param  \App\Models\Pengajuan  $pengajuan
     * @return void
     */
    public function updated(Pengajuan  $pengajuan)
    {

        if ($pengajuan->kode_status == 'T04'){
            $pin = Pin::where('kode_pengajuan', $pengajuan->id)->get();
            foreach ($pin as $item){
                $item->update(['status' => 'B01']);
            }
        }

        $this->notificationHandling($pengajuan, 'updated');
    }

    private function notificationHandling(Pengajuan  $pengajuan, String $action)
    {
        $data = Pengajuan::with('pin.penawaran', 'pin.tukang.user')->whereId($pengajuan->id)->first();
        switch ($action){
            case 'updated':
                //deep_id == pengajuan
                if ($data->kode_status == "S02") {
                    foreach ($data->pin as $item){
                        createNotification(
                            $item->kode_tukang,
                            'Pengajuan',
                            'Klien telah melakukan perubahan pada Pengajuan.',
                            $data->nama_proyek,
                            $data->id,
                            'tukang',
                            'update',
                            PengajuanEventController::eventCreated());
                    }
                }
                //deep_id == pengajuan
                if ($data->kode_status == "T03") {
                    createNotification(
                        $data->kode_client,
                        'Pengajuan',
                        'Dikarenakan semua tukang menolak maka Pengajuan anda Otomatis dibatalkan.',
                        $data->nama_proyek,
                        $data->id,
                        'client',
                        'cancel',
                        PengajuanEventController::eventCreated());
                }
                break;
        }
    }
}
