<?php

namespace App\Observers;

use App\Models\Rate;
use App\Models\User;

class UserObserver
{
    /**
     * Handle the User "created" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function created(User $user)
    {
        if ($user->kode_role == 2){
            $rate = new Rate();
            $rate->kode_tukang = $user->id;
            $rate->value_rate = 1;
            $rate->count_rate = 0;
            $rate->save();

            $rate = new Rate();
            $rate->kode_tukang = $user->id;
            $rate->value_rate = 2;
            $rate->count_rate = 0;
            $rate->save();

            $rate = new Rate();
            $rate->kode_tukang = $user->id;
            $rate->value_rate = 3;
            $rate->count_rate = 0;
            $rate->save();

            $rate = new Rate();
            $rate->kode_tukang = $user->id;
            $rate->value_rate = 4;
            $rate->count_rate = 0;
            $rate->save();

            $rate = new Rate();
            $rate->kode_tukang = $user->id;
            $rate->value_rate = 5;
            $rate->count_rate = 0;
            $rate->save();
        }
    }

    /**
     * Handle the User "updated" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function updated(User $user)
    {
        //
    }

    /**
     * Handle the User "deleted" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function deleted(User $user)
    {
        //
    }

    /**
     * Handle the User "restored" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function restored(User $user)
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function forceDeleted(User $user)
    {
        //
    }
}
