<?php

namespace App\Providers;

use App\Models\Pembayaran;
use App\Models\Penawaran;
use App\Models\Pengajuan;
use App\Models\Pin;
use App\Models\Rate;
use App\Models\Transaksi_Pembayaran;
use App\Models\User;
use App\Models\VoteRate;
use App\Observers\PembayaranObserver;
use App\Observers\PenawaranObserver;
use App\Observers\PengajuanObserver;
use App\Observers\PinObserver;
use App\Observers\RateObserver;
use App\Observers\TransaksiPembayaranObserver;
use App\Observers\UserObserver;
use App\Observers\VoteRateObserver;
use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;

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
        Penawaran::observe(PenawaranObserver::class);
        Pin::observe(PinObserver::class);
        Transaksi_Pembayaran::observe(TransaksiPembayaranObserver::class);
    }
}
