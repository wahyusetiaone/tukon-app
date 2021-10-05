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
}
