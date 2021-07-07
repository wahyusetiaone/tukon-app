<?php

namespace App\Observers;

use App\Models\Rate;
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
        //
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
