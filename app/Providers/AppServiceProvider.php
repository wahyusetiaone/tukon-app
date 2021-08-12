<?php

namespace App\Providers;

use App\Models\DocumentationProgress;
use App\Models\OnProgress;
use App\Models\OnStepProgress;
use App\Models\Pin;
use App\Models\Progress;
use App\Models\Project;
use App\Models\Rate;
use App\Models\Revisi;
use App\Models\Transaksi_Pembayaran;
use App\Models\Transaksi_Penarikan;
use App\Models\User;
use App\Models\VoteRate;
use App\Observers\DocumentationProgressObserver;
use App\Observers\OnProgressObserver;
use App\Observers\PembayaranObserver;
use App\Observers\PengajuanObserver;
use App\Observers\PinObserver;
use App\Observers\ProgressObserver;
use App\Observers\ProjectObserver;
use App\Observers\RateObserver;
use App\Observers\RevisiObserver;
use App\Observers\TransaksiPembayaranObserver;
use App\Observers\TransaksiPenarikanDanaObserver;
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
//        Penawaran::observe(PenawaranObserver::class);
        Pin::observe(PinObserver::class);
        Transaksi_Pembayaran::observe(TransaksiPembayaranObserver::class);
        Progress::observe(ProgressObserver::class);
        Project::observe(ProjectObserver::class);
        Revisi::observe(RevisiObserver::class);
        OnProgress::observe(OnProgressObserver::class);
        DocumentationProgress::observe(DocumentationProgressObserver::class);
        Transaksi_Penarikan::observe(TransaksiPenarikanDanaObserver::class);
    }
}
