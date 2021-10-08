<?php

namespace App\Observers;

use App\Events\PenawaranEventController;
use App\Events\PengajuanEventController;
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
     * Handle the User "created" event.
     *
     * @param \App\Models\Pin $pin
     * @return void
     */
    public function created(Pin $pin)
    {
        $this->notificationHandling($pin, 'created');
    }

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
            $dat = Pin::with('penawaran')->where('id', $pin->id)->first();
            $pembayaran = new Pembayaran();
            $pembayaran->kode_pin = $pin->id;
            $pembayaran->total_tagihan = $dat->penawaran->harga_total;
            $pembayaran->save();
        }
        if ($pin->status == "B02") {
            $count = Pin::select('id')->where('kode_pengajuan', $pin->kode_pengajuan)->count();
            if ($count <= 1) {
                Pengajuan::whereId($pin->kode_pengajuan)->update(['kode_status' => 'T03']);
            }
        }

        if ($pin->status == 'B99') {
            $countRealTukang = Pin::where('kode_pengajuan', $pin->kode_pengajuan)->count();
            $countAllCancle = Pin::where(function ($query) use ($pin) {
                $query
                    ->where('kode_pengajuan', $pin->kode_pengajuan)
                    ->where('status', 'B01');
            })
                ->orWhere(function ($query) use ($pin) {
                    $query
                        ->where('kode_pengajuan' , $pin->kode_pengajuan)
                        ->where('status' , 'B02');
                })
                ->orWhere(function ($query) use ($pin) {
                    $query
                        ->where('kode_pengajuan', $pin->kode_pengajuan)
                        ->where('status' , 'B99');
                })
                ->count();
            if ($countRealTukang == $countAllCancle) {
                Pengajuan::whereId($pin->kode_pengajuan)->update(['kode_status' => 'T05']);
            }
        }

        $this->notificationHandling($pin, 'updated');

    }

    private function notificationHandling(Pin $pin, string $action)
    {
        $data = Pin::with('pengajuan.client.user', 'penawaran', 'tukang.user')->whereId($pin->id)->first();
        switch ($action) {
            case 'created':
                //deep_id == pin
                createNotification($pin->kode_tukang, 'Pengajuan', 'Anda mendapatkan Pengajuan Baru dari ' . $data->pengajuan->client->user->name, $data->pengajuan->nama_proyek, $pin->id, 'tukang', 'add', PengajuanEventController::eventCreated());
                break;
            case 'updated':
                //deep_id == penawaran
                if ($pin->status == "D01A") {
                    createNotification(
                        $pin->kode_tukang,
                        'Penawaran',
                        'Update status Penawaran disetujui klien ' . $data->pengajuan->client->user->name,
                        $data->pengajuan->nama_proyek,
                        $data->penawaran->id,
                        'tukang',
                        'update',
                        PenawaranEventController::eventCreated());
                }
                //deep_id == penawaran
                if ($pin->status == "D02") {
                    createNotification(
                        $data->pengajuan->kode_client,
                        'Penawaran',
                        'Update status Penawaran disetujui tukang ' . $data->tukang->user->name,
                        $data->pengajuan->nama_proyek,
                        $data->penawaran->id,
                        'client',
                        'update',
                        PenawaranEventController::eventCreated());
                }
                //deep_id == pengajuan
                if ($pin->status == "B02") {
                    createNotification(
                        $data->pengajuan->kode_client,
                        'Pengajuan',
                        'Update status Pengajuan ditolak tukang ' . $data->tukang->user->name,
                        $data->pengajuan->nama_proyek,
                        $data->pengajuan->id,
                        'client',
                        'cancel',
                        PengajuanEventController::eventCreated());
                }
                //deep_id == pengajuan
                if ($pin->status == "B01") {
                    createNotification(
                        $pin->kode_tukang,
                        'Pengajuan',
                        'Update status Pengajuan dibatalkan klien ' . $data->pengajuan->client->user->name,
                        $data->pengajuan->nama_proyek,
                        $data->pengajuan->id,
                        'tukang',
                        'cancel',
                        PengajuanEventController::eventCreated());
                }
                //deep_id == penawaran
                if ($pin->status == "B04") {
                    createNotification(
                        $pin->kode_tukang,
                        'Penawaran',
                        'Update status Penawaran telah dimenangkan pihak lain.',
                        $data->pengajuan->nama_proyek,
                        $data->penawaran->id,
                        'tukang',
                        'cancel',
                        PengajuanEventController::eventCreated());
                }
                break;
        }
    }
}
