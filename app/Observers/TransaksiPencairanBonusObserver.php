<?php

namespace App\Observers;

use App\Models\BonusAdminCabang;
use App\Models\Transaksi_Pencairan_Bonus;

class TransaksiPencairanBonusObserver
{
    /**
     * Handle the User "created" event.
     *
     * @param \App\Models\Transaksi_Pengembalian $tr
     * @return void
     */
    public function created(Transaksi_Pencairan_Bonus $tr)
    {
        $bonus = BonusAdminCabang::find($tr->bonus_admin_id);
        $bonus->kode_status ='BA02';
        $bonus->save();
    }

    /**
     * Handle the User "created" event.
     *
     * @param \App\Models\Transaksi_Pengembalian $tr
     * @return void
     */
    public function updated(Transaksi_Pencairan_Bonus $tr)
    {
        if ($tr->kode_status == 'TB02'){
            $bonus = BonusAdminCabang::find($tr->bonus_admin_id);
            $bonus->kode_status ='BA04';
            $bonus->save();
        }
        if ($tr->kode_status == 'TB03'){
            $bonus = BonusAdminCabang::find($tr->bonus_admin_id);
            $bonus->kode_status ='BA03';
            $bonus->save();
        }
    }
}
