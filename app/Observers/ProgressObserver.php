<?php

namespace App\Observers;

use App\Models\OnStepProgress;
use App\Models\PlanProgress;
use App\Models\Progress;
use App\Models\Project;

class ProgressObserver
{
    /**
     * Handle the Progress "updated" event.
     *
     * @param  \App\Models\Progress  $progress
     * @return void
     */
    public function updated(Progress $progress){
        $presentase = ($progress->now / $progress->deadlineinday) * 100;
        Project::where('id', $progress->kode_project)->update(["persentase_progress" => $presentase]);
    }
}
