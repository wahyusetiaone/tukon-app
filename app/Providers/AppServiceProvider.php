<?php

namespace App\Providers;

use App\Models\DocumentationProgress;
use App\Models\Invoice;
use App\Models\OnProgress;
use App\Models\OnStepProgress;
use App\Models\Pembayaran;
use App\Models\Penawaran;
use App\Models\Pengajuan;
use App\Models\Pin;
use App\Models\Progress;
use App\Models\Project;
use App\Models\Rate;
use App\Models\Revisi;
use App\Models\Transaksi_Pembayaran;
use App\Models\Transaksi_Penarikan;
use App\Models\Transaksi_Pengembalian;
use App\Models\User;
use App\Models\VoteRate;
use App\Observers\DocumentationProgressObserver;
use App\Observers\InvoiceObserver;
use App\Observers\OnProgressObserver;
use App\Observers\PembayaranObserver;
use App\Observers\PenawaranObserver;
use App\Observers\PengajuanObserver;
use App\Observers\PinObserver;
use App\Observers\ProgressObserver;
use App\Observers\ProjectObserver;
use App\Observers\RateObserver;
use App\Observers\RevisiObserver;
use App\Observers\TransaksiPembayaranObserver;
use App\Observers\TransaksiPenarikanDanaObserver;
use App\Observers\TransaksiPengembalianDanaObserver;
use App\Observers\UserObserver;
use App\Observers\VoteRateObserver;
use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;
use Laravel\Passport\Console\ClientCommand;
use Laravel\Passport\Console\InstallCommand;
use Laravel\Passport\Console\KeysCommand;


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
        //time zone ID
        config(['app.locale' => 'id']);
        Carbon::setLocale('id');
        date_default_timezone_set('Asia/Jakarta');

        //passport
        $this->commands([
            InstallCommand::class,
            ClientCommand::class,
            KeysCommand::class,
        ]);

        User::observe(UserObserver::class);
        VoteRate::observe(VoteRateObserver::class);
        Penawaran::observe(PenawaranObserver::class);
        Pin::observe(PinObserver::class);
        Transaksi_Pembayaran::observe(TransaksiPembayaranObserver::class);
        Progress::observe(ProgressObserver::class);
        Project::observe(ProjectObserver::class);
        Revisi::observe(RevisiObserver::class);
        OnProgress::observe(OnProgressObserver::class);
        DocumentationProgress::observe(DocumentationProgressObserver::class);
        Transaksi_Penarikan::observe(TransaksiPenarikanDanaObserver::class);
        Transaksi_Pengembalian::observe(TransaksiPengembalianDanaObserver::class);
        Pengajuan::observe(PengajuanObserver::class);
        Pembayaran::observe(PembayaranObserver::class);
        Invoice::observe(InvoiceObserver::class);
    }
}
