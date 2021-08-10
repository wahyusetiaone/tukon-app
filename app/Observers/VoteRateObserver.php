<?php

namespace App\Observers;

use App\Models\Rate;
use App\Models\Tukang;
use App\Models\VoteRate;

class VoteRateObserver
{
    /**
     * Handle the VoteRate "created" event.
     *
     * @param  \App\Models\VoteRate  $voteRate
     * @return void
     */
    public function created(VoteRate $voteRate)
    {
        $rate = VoteRate::where(['kode_tukang'=>$voteRate->kode_tukang,'value'=>$voteRate->value])->get();
        $recounting = count($rate);
        Rate::where(['kode_tukang'=>$voteRate->kode_tukang,'value_rate'=>$voteRate->value])->update(['count_rate'=>$recounting]);
        Tukang::whereId($voteRate->kode_tukang)->update(["rate"=>5.0]);

        //for cunting score of rate
        $cal = Rate::where(['kode_tukang'=>$voteRate->kode_tukang])->get();
        $total_data = 0;
        $freq = 0;
        foreach ($cal as $arate){
            $total_data = $total_data + ($arate->value_rate * $arate->count_rate);
            $freq = $freq + $arate->count_rate;
        }
        $score = $total_data/$freq;

        Tukang::whereId($voteRate->kode_tukang)->update(["rate"=>$score]);
    }

    /**
     * Handle the VoteRate "updated" event.
     *
     * @param  \App\Models\VoteRate  $voteRate
     * @return void
     */
    public function updated(VoteRate $voteRate)
    {
        //
    }

    /**
     * Handle the VoteRate "deleted" event.
     *
     * @param  \App\Models\VoteRate  $voteRate
     * @return void
     */
    public function deleted(VoteRate $voteRate)
    {
        $rate = VoteRate::where(['kode_tukang'=>$voteRate->kode_tukang,'value'=>$voteRate->value])->get();
        if (empty($result)) {
            $recounting = 0;
        }else{
            $recounting = count($rate);
        }
        Rate::where(['kode_tukang'=>$voteRate->kode_tukang,'value_rate'=>$voteRate->value])->update(['count_rate'=>$recounting]);

        //for cunting score of rate
        $cal = Rate::where(['kode_tukang'=>$voteRate->kode_tukang])->get();
        $total_data = 0;
        $freq = 0;
        foreach ($cal as $arate){
            $total_data = $total_data + ($arate->value_rate * $arate->count_rate);
            $freq = $freq + $arate->count_rate;
        }
        $score = $freq == 0 ? 0 : ($total_data/$freq);

        Tukang::whereId($voteRate->kode_tukang)->update(["rate"=>$score]);
    }

    /**
     * Handle the VoteRate "restored" event.
     *
     * @param  \App\Models\VoteRate  $voteRate
     * @return void
     */
    public function restored(VoteRate $voteRate)
    {
        //
    }

    /**
     * Handle the VoteRate "force deleted" event.
     *
     * @param  \App\Models\VoteRate  $voteRate
     * @return void
     */
    public function forceDeleted(VoteRate $voteRate)
    {
        //
    }
}
