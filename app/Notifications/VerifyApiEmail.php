<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\URL;
use Illuminate\Auth\Notifications\VerifyEmail as VerifyEmailBase;

class VerifyApiEmail extends VerifyEmailBase
{
    /**
     * Get the verification URL for the given notifiable.
     *
     * @param mixed $notifiable
     * @return string
     */
    protected function verificationUrl($notifiable)
    {
        return URL::temporarySignedRoute(
            'verificationapi.verify', Carbon::now()->addMinutes(60), ['id' => $notifiable->getKey()]
        ); // this will basically mimic the email endpoint with get request
    }

    /**
     * Get the verify email notification mail message for the given URL.
     *
     * @param  string  $url
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    protected function buildMailMessage($url)
    {
        return (new MailMessage)
            ->subject(Lang::get('Pemberitauan Verifikasi Alamat Email'))
            ->line(Lang::get('Silakan klik tombol di bawah ini untuk memverifikasi alamat email Anda.'))
            ->action(Lang::get('Verifikasi Alamat Email'), $url)
            ->line(Lang::get('Jika Anda tidak membuat akun, abaikan pesan ini.'));
    }
}
