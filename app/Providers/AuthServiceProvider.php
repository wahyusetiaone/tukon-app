<?php

namespace App\Providers;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Lang;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
         'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Passport::routes();

        //overwrite email content
        VerifyEmail::toMailUsing(function ($notifiable, $url) {
            return (new MailMessage)
                ->subject(Lang::get('Pemberitauan Verifikasi Alamat Email'))
                ->line(Lang::get('Silakan klik tombol di bawah ini untuk memverifikasi alamat email Anda.'))
                ->action(Lang::get('Verifikasi Alamat Email'), $url)
                ->line(Lang::get('Jika Anda tidak membuat akun, abaikan pesan ini.'));
        });
    }
}
