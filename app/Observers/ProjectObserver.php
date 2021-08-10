<?php

namespace App\Observers;

use App\Models\Limitasi_Penarikan;
use App\Models\PenarikanDana;
use App\Models\Progress;
use App\Models\Project;
use Database\Seeders\LimitasiPenarikanSeeder;
use DateTime;

class ProjectObserver
{

    /**
     * Handle the OnStepProgress "created" event.
     *
     * @param  \App\Models\Project  $project
     * @return void
     */
    public function created(Project $project){
        $data = Project::with('pembayaran', 'pembayaran.pin', 'pembayaran.pin.pengajuan', 'pembayaran.pin.penawaran', 'pembayaran.pin.penawaran.bpa')->where('id', $project->id)->first();
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
        $total_bayar = $data->pembayaran->total_tagihan;
        $total_dana = $total_bayar - ($total_bayar * ($bpa/100));
        $limitasi = $total_dana * ($lim->value/100);
        $penarikadana->total_dana = $total_dana;
        $penarikadana->limitasi = $limitasi;
        $penarikadana->sisa_penarikan = $limitasi;
        $penarikadana->save();
    }

    /**
     * Handle the OnStepProgress "updating" event.
     *
     * @param  \App\Models\Project  $project
     * @return boolean
     */
    public function updating(Project $project){

        $dat = Project::find($project->id)->first();

        if ($dat->kode_status == "ON02" && $project->kode_status == "ON04"){
            Project::whereId($project->id)->update(['kode_status' => "ON05"]);
            return false;
        }

        if ($dat->kode_status == "ON04" && $project->kode_status == "ON02"){
            Project::whereId($project->id)->update(['kode_status' => "ON05"]);
            return false;
        }
        return true;
    }
}
