<?php

namespace App\Observers;

use App\Events\BonusEventController;
use App\Models\BonusAdminCabang;

class BonusObserver
{
    /**
     * Handle the OnStepProgress "created" event.
     *
     * @param \App\Models\BonusAdminCabang $bonus
     * @return void
     */
    public function created(BonusAdminCabang $bonus)
    {
        $this->notificationHandling($bonus, 'created');
    }
    /**
     * Handle the OnStepProgress "created" event.
     *
     * @param \App\Models\BonusAdminCabang $bonus
     * @return void
     */
    public function updated(BonusAdminCabang $bonus)
    {
        $this->notificationHandling($bonus, 'updated');
    }

    private function notificationHandling(BonusAdminCabang $bonus, string $action)
    {
        switch ($action) {
            case 'created':
                //deep_id == bonus
                createNotification(
                    $bonus->admin_id,
                    'Bonus Proyek',
                    'Anda mendapatkan bonus karena tukang yang anda verifikasi mendapatkan proyek',
                    'Bonus Proyek',
                    $bonus->id,
                    'admin_cabang',
                    'created',
                    BonusEventController::eventCreated());
                break;
            case 'updated':
                //deep_id == bonus
                if ($bonus->kode_status == "BA02") {
                    createNotification(
                        $bonus->admin_id,
                        'Pengajuan Pencairan Bonus Proyek.',
                        'Pengajuan Pencairan Bonus Proyek.',
                        'Pengajuan Pencairan Bonus Proyek',
                        $bonus->id,
                        'admin',
                        'update',
                        BonusEventController::eventCreated());
                }
                //deep_id == bonus
                if ($bonus->kode_status == "BA03") {
                    createNotification(
                        $bonus->admin_id,
                        'Pencairan Bonus Proyek berhasil.',
                        'Pencairan Bonus Proyek anda telah berhasil.',
                        'Pencairan Bonus Proyek',
                        $bonus->id,
                        'admin_cabang',
                        'update',
                        BonusEventController::eventCreated());
                }
                //deep_id == bonus
                if ($bonus->kode_status == "BA04") {
                    createNotification(
                        $bonus->admin_id,
                        'Pencairan Bonus Proyek ditolak.',
                        'Pencairan Bonus Proyek anda ditolak.',
                        'Pencairan Bonus Proyek',
                        $bonus->id,
                        'admin_cabang',
                        'update',
                        BonusEventController::eventCreated());
                }
                //deep_id == bonus
                if ($bonus->kode_status == "BA05") {
                    createNotification(
                        $bonus->admin_id,
                        'Bonus Proyek Dibatalkan.',
                        'Bonus Proyek anda dibatalkan karena klien membatalkan proyek.',
                        'Bonus Proyek',
                        $bonus->id,
                        'admin_cabang',
                        'update',
                        BonusEventController::eventCreated());
                }
                break;
        }
    }
}
