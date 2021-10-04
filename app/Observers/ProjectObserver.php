<?php

namespace App\Observers;

use App\Events\ProyekEventController;
use App\Models\BACabang;
use App\Models\BonusAdminCabang;
use App\Models\Limitasi_Penarikan;
use App\Models\PemasukanAplikasi;
use App\Models\Penalty;
use App\Models\PenarikanDana;
use App\Models\PengembalianDana;
use App\Models\Progress;
use App\Models\Project;
use Database\Seeders\LimitasiPenarikanSeeder;
use DateTime;
use Illuminate\Support\Facades\Log;

class ProjectObserver
{

    /**
     * Handle the OnStepProgress "created" event.
     *
     * @param \App\Models\Project $project
     * @return void
     */
    public function created(Project $project)
    {
        $data = Project::with('pembayaran', 'pembayaran.pin', 'pembayaran.pin.pengajuan', 'pembayaran.pin.penawaran', 'pembayaran.pin.penawaran.bpa', 'pembayaran.pin.penawaran.bac', 'pembayaran.pin.tukang.verification', 'pembayaran.pin.penawaran.komponen')->where('id', $project->id)->first();
        $fdate = $data->pembayaran->pin->pengajuan->deadline;
        $tdate = date("Y-m-d H:i:s");
        $datetime1 = new DateTime($fdate);
        $datetime2 = new DateTime($tdate);
        $interval = $datetime1->diff($datetime2);
        $days = $interval->format('%a');//now do whatever you like with $days
        $daysv = $days + 1;

        $progress = new Progress();
        $progress->kode_project = $project->id;
        $progress->deadlineinday = $daysv;
        $progress->save();

        $lim = Limitasi_Penarikan::where('id', 1)->first();

        $penarikadana = new PenarikanDana();
        $penarikadana->kode_project = $project->id;
        $penarikadana->kode_limitasi = 1;
        $bpa = $data->pembayaran->pin->penawaran->bpa->bpa;
        $bac = $data->pembayaran->pin->penawaran->bac->bac;

        $harga_total = $data->pembayaran->total_tagihan;
        //harga_asli
        $total_bayar = 0;
        foreach ($data->pembayaran->pin->penawaran->komponen as $item){
            $total_bayar += $item->harga;
        }

        //keuntungan app
        $k_bpa = ($total_bayar * ($bpa / 100));
        $app = new PemasukanAplikasi();
        $app->deep_id = $data->id;
        $app->keterangan = 'Pembayaran Proyek';
        $app->jumlah = $k_bpa;
        $app->save();

        if ($data->pembayaran->pin->tukang->verifikasi_lokasi){
            //bonus admin
            $k_bac = ($total_bayar * ($bac / 100));
            $admin = new BonusAdminCabang();
            $admin->kode_project = $data->id;
            $admin->admin_id = $data->pembayaran->pin->tukang->verification->admin_id;
            $admin->bonus = $k_bac;
            $admin->save();
            $k_bpa += $k_bac;
        }

        $total_dana = $harga_total - $k_bpa;
        $limitasi = $total_dana * ($lim->value / 100);
        $penarikadana->total_dana = $total_dana;
        $penarikadana->limitasi = $limitasi;
        $penarikadana->sisa_penarikan = $limitasi;
        $penarikadana->save();
    }

    /**
     * Handle the OnStepProgress "updating" event.
     *
     * @param \App\Models\Project $project
     * @return boolean
     */
//    public function updating(Project $project){
//
//        $dat = Project::find($project->id)->first();
//
//        if ($dat->kode_status == "ON02" && $project->kode_status == "ON04"){
//            Project::whereId($project->id)->update(['kode_status' => "ON05"]);
//            return false;
//        }
//
//        if ($dat->kode_status == "ON04" && $project->kode_status == "ON02"){
//            Project::whereId($project->id)->update(['kode_status' => "ON05"]);
//            return false;
//        }
//        return true;
//    }

    /**
     * Handle the Progress "updated" event.
     *
     * @param \App\Models\Project $project
     * @return void
     */
    public function updated(Project $project)
    {
        if ($project->kode_status == "ON03") {
            $penarikan_dana = PenarikanDana::with('project.pembayaran.pin.tukang','project.pembayaran.pin.penawaran.komponen','project.pembayaran.pin.penawaran.bac')->where('kode_project', $project->id)->first();
            $penalty = Penalty::take(1)->first();
            $cutoff = $penarikan_dana->persentase_penarikan + $penalty->value;
            $roff = 100 - $cutoff;
            $return = ($penarikan_dana->total_dana * $roff) / 100;

            if ($penarikan_dana->project->pembayaran->pin->tukang->verifikasi_lokasi){
                $harga_asli = 0;
                foreach ($penarikan_dana->project->pembayaran->pin->penawaran->komponen as $item){
                    $harga_asli += $item->harga;
                }
                $return +=  ($harga_asli * $penarikan_dana->project->pembayaran->pin->penawaran->bac->bac) / 100;

                //ubah status bonus ke batal
                $bonus = BonusAdminCabang::where('kode_project', $project->id)->first();
                $bonus->kode_status = 'BA05';
                $bonus->save();
            }

            $pengembalian = new PengembalianDana();
            $pengembalian->kode_project = $project->id;
            $pengembalian->jmlh_pengembalian_persentasi = $roff;
            $pengembalian->jmlh_pengembalian = $return;
            $pengembalian->kode_status = 'PM01';
            $pengembalian->kode_penalty = $penalty->id;
            $pengembalian->save();
        }
        if ($project->kode_status == "ON05") {
            $penarikan_dana = PenarikanDana::where('kode_project', $project->id)->first();
            //kode 2 adalah 100%
            $limitasi = Limitasi_Penarikan::where('id', 2)->first();
            $sisa_dari_total_dana = $penarikan_dana->total_dana * ($limitasi->value / 100);
            $penarikan_dana->kode_limitasi = $limitasi->id;
            $penarikan_dana->limitasi = $penarikan_dana->limitasi + $sisa_dari_total_dana;
            $penarikan_dana->sisa_penarikan = $penarikan_dana->sisa_penarikan + $sisa_dari_total_dana;
            $penarikan_dana->save();
        }
        $this->notificationHandling($project, 'updated');
    }

    private function notificationHandling(Project $project, string $action)
    {
        $data = Project::with('pembayaran.pin.pengajuan.client.user', 'pembayaran.pin.tukang.user')->whereId($project->id)->first();
        switch ($action) {
            case 'updated':
                //deep_id == project
                if ($data->kode_status == "ON01") {
                    createNotification(
                        $data->pembayaran->pin->pengajuan->kode_client,
                        'Proyek',
                        'Tukang ' . $data->pembayaran->pin->tukang->user->name . ' upload progress terbaru.',
                        $data->pembayaran->pin->pengajuan->nama_proyek,
                        $data->id,
                        'client',
                        'update',
                        ProyekEventController::eventCreated());
                }
                //deep_id == project
                if ($data->kode_status == "ON02") {
                    createNotification(
                        $data->pembayaran->pin->kode_tukang,
                        'Proyek',
                        'Klien menyetujui penyelesaian Proyek.',
                        $data->pembayaran->pin->pengajuan->nama_proyek,
                        $data->id,
                        'tukang',
                        'update',
                        ProyekEventController::eventCreated());
                }
                //deep_id == project
                if ($data->kode_status == "ON03") {
                    createNotification(
                        $data->pembayaran->pin->kode_tukang,
                        'Proyek',
                        'Klien membatalkan Proyek.',
                        $data->pembayaran->pin->pengajuan->nama_proyek,
                        $data->id,
                        'tukang',
                        'cancel',
                        ProyekEventController::eventCreated());
                }
                //deep_id == project
                if ($data->kode_status == "ON04") {
                    createNotification(
                        $data->pembayaran->pin->pengajuan->kode_client,
                        'Proyek',
                        'Tukang menyetujui penyelesaian Proyek.',
                        $data->pembayaran->pin->pengajuan->nama_proyek,
                        $data->id,
                        'client',
                        'update',
                        ProyekEventController::eventCreated());
                }
                //deep_id == project
                if ($data->kode_status == "ON05") {
                    createNotification(
                        $data->pembayaran->pin->pengajuan->kode_client,
                        'Proyek',
                        'Proyek Selesai.',
                        $data->pembayaran->pin->pengajuan->nama_proyek,
                        $data->id,
                        'client',
                        'update',
                        ProyekEventController::eventCreated());
                    createNotification(
                        $data->pembayaran->pin->kode_tukang,
                        'Proyek',
                        'Proyek Selesai.',
                        $data->pembayaran->pin->pengajuan->nama_proyek,
                        $data->id,
                        'tukang',
                        'update',
                        ProyekEventController::eventCreated());
                }
                break;
        }
    }
}
