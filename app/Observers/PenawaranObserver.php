<?php

namespace App\Observers;

use App\Events\PenawaranEventController;
use App\Models\History_Penawaran;
use App\Models\Penawaran;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PenawaranObserver
{
    /**
     * Handle the User "created" event.
     *
     * @param  \App\Models\Penawaran  $penawaran
     * @return void
     */
    public function created(Penawaran $penawaran)
    {
        $this->notificationHandling($penawaran, 'created');
    }

    /**
     * Handle the User "updated" event.
     *
     * @param  \App\Models\Penawaran  $penawaran
     * @return void
     */
    public function updated(Penawaran $penawaran)
    {
        $this->notificationHandling($penawaran, 'updated');
    }

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

    private function notificationHandling(Penawaran $penawaran, String $action)
    {
        $data = Penawaran::with('pin.pengajuan.client.user', 'pin.tukang.user')->where('id',$penawaran->id)->first();
        switch ($action){
            case 'created':
                //deep_id == penawaran
                createNotification(
                    $data->pin->pengajuan->kode_client,
                    'Penawaran',
                    'Anda mendapatkan Penawaran Baru dari Tukang '.$data->pin->tukang->user->name,
                    $data->pin->pengajuan->nama_proyek,
                    $data->id,
                    'client',
                    'add',
                    PenawaranEventController::eventCreated());
                break;
            case 'updated':
                //deep_id == penawaran
                if ($data->kode_status == "T02A") {
                    createNotification(
                        $data->pin->kode_tukang,
                        'Penawaran',
                        'Klien memita revisi atas penawaran pada projek.',
                        $data->pin->pengajuan->nama_proyek,
                        $data->id,
                        'tukang',
                        'update',
                        PenawaranEventController::eventCreated());
                }
                //deep_id == penawaran
                if ($data->kode_status == "T02") {
                    createNotification(
                        $data->pin->pengajuan->kode_client,
                        'Penawaran',
                        'Tukang '.$data->pin->tukang->user->name.' mengirimkan revisi pada penawaran projek.',
                        $data->pin->pengajuan->nama_proyek,
                        $data->id,
                        'client',
                        'update',
                        PenawaranEventController::eventCreated());
                }
                break;
        }
    }

}
