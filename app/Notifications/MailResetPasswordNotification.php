<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

//custom
use Illuminate\Support\Facades\Lang;
use Illuminate\Auth\Notifications\ResetPassword;

class MailResetPasswordNotification extends ResetPassword
{
    use Queueable;

    protected $pageUrl;
    public $token;
    private $pageUrlMobile;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($token)
    {
        parent::__construct($token);
        $this->pageUrl = env('APP_URL');
        $this->pageUrlMobile = env('APP_URL_MOBILE');
// we can set whatever we want here, or use .env to set environmental variables
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        if (static::$toMailCallback) {
            return call_user_func(static::$toMailCallback, $notifiable, $this->token);
        }
        return (new MailMessage)
        ->subject(Lang::get('Pemberitahuan Setel Ulang Kata Sandi'))
            ->line(Lang::get('Anda menerima email ini karena kami menerima permintaan penyetelan ulang sandi untuk akun Anda.'))
            ->line(Lang::get('Klik tombol di bawah'))
//            ->action(Lang::get('Setel Ulang Kata Sandi'), $this->pageUrl . "?token=" . $this->token)
            ->action(Lang::get('Setel Ulang Kata Sandi'), url('password/reset', $this->token))
//            ->line(Lang::get('Or using Tukon Application mobile, '))
//            ->line(Lang::get($this->pageUrlMobile . $this->token))
            ->line(Lang::get('Tautan pengaturan ulang kata sandi ini akan kedaluwarsa dalam :count menit.', ['count' => config('auth.passwords.users.expire')]))
            ->line(Lang::get('Jika Anda tidak meminta pengaturan ulang kata sandi, tidak ada tindakan lebih lanjut yang diperlukan.'));
    }

}
