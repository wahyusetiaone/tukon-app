<?php

namespace App\Observers;

use App\Models\OnStepProgress;
use App\Models\PlanProgress;
use App\Models\Project;

class ProgressObserver
{
    /**
     * Handle the OnStepProgress "created" event.
     *
     * @param  \App\Models\OnStepProgress  $progress
     * @return void
     */
    public function created(OnStepProgress $progress){
        $prog = $progress->kode_plan_progress / PlanProgress::count();
        $prog = $prog * 100.00;

        Project::whereId($progress->kode_project)->update(["progress" => $prog]);

    }
}
