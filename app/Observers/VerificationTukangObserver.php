<?php

namespace App\Observers;

use App\Events\VerificationEventController;
use App\Models\Tukang;
use App\Models\VerificationTukang;

class VerificationTukangObserver
{
    /**
     * Handle the User "updated" event.
     *
     * @param \App\Models\VerificationTukang $verification
     * @return void
     */
    public function updated(VerificationTukang $verification)
    {

        if ($verification->status == 'V02') {
            $tukang = Tukang::whereId($verification->tukang_id)->first();
            $tukang->verifikasi_lokasi = true;
            $tukang->save();
            $this->notificationHandling($verification, 'updated');
        }
        if ($verification->status == 'V03') {
            $this->notificationHandling($verification, 'updated');
        }
    }

    private function notificationHandling(VerificationTukang  $verification, String $action)
    {
        switch ($action){
            case 'updated':
                //deep_id == tukang
                if ($verification->status == "V02") {
                    createNotification(
                        $verification->tukang_id,
                        'Verifikasi',
                        'Akun Anda telah diverifikasi oleh Tukon.',
                        'Verifikasi Akun',
                        $verification->tukang_id,
                        'tukang',
                        'update',
                        VerificationEventController::eventCreated());
                    createNotification(
                        $verification->admin_id,
                        'Verifikasi',
                        'Akun Verifikasi Berhasil.',
                        'Verifikasi Akun Penyedia Jasa',
                        $verification->tukang_id,
                        'admin_cabang',
                        'update',
                        VerificationEventController::eventCreated());
                }
                //deep_id == tukang
                if ($verification->status == "V03") {
                    createNotification(
                        $verification->admin_id,
                        'Verifikasi',
                        'Akun Verifikasi Gagal.',
                        'Verifikasi Akun Penyedia Jasa',
                        $verification->tukang_id,
                        'admin_cabang',
                        'update',
                        VerificationEventController::eventCreated());
                }
                break;
        }
    }
}
