<?php

namespace App\Observers;

use App\Models\OnProgress;
use App\Models\Progress;

class OnProgressObserver
{
    /**
     * Handle the OnStepProgress "created" event.
     *
     * @param  \App\Models\OnProgress  $onprogress
     * @return void
     */
    public function created(OnProgress $onprogress){
        $jmlh_onprogress = OnProgress::where('kode_progress', $onprogress->kode_progress)->count();
//        Progress::where('id',$onprogress->kode_progress)->update(['now'=> $jmlh_onprogress]);
        $progress = Progress::where('id',$onprogress->kode_progress)->first();
        $progress->now = $jmlh_onprogress;
        $progress->save();
    }
}
