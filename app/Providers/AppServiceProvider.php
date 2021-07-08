<?php

namespace App\Providers;

use App\Models\Rate;
use App\Models\User;
use App\Models\VoteRate;
use App\Observers\RateObserver;
use App\Observers\UserObserver;
use App\Observers\VoteRateObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        User::observe(UserObserver::class);
        VoteRate::observe(VoteRateObserver::class);
    }
}
