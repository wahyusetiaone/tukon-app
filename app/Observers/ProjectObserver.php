<?php

namespace App\Observers;

use App\Models\Project;

class ProjectObserver
{
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
