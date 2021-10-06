<?php

namespace App\Observers;

use App\Models\NegoPenawaran;
use App\Models\Penawaran;
use App\Models\Pin;

class NegoPenawaranObserver
{
    /**
     * Handle the Revisi "created" event.
     *
     * @param \App\Models\NegoPenawaran $nego
     * @return void
     */
    public function created(NegoPenawaran $nego)
    {
        //ubah status penawaran
        $pena = Penawaran::where('id',$nego->kode_penawaran)->first();
        $pena->update(['kode_status'=>'T02A']);
    }

    /**
     * Handle the Revisi "created" event.
     *
     * @param \App\Models\NegoPenawaran $nego
     * @return void
     */
    public function updated(NegoPenawaran $nego)
    {
        $pena = Penawaran::where('id',$nego->kode_penawaran)->first();
        //ubah status penawaran
        if ($nego->disetujui){
            $pena->update(['kode_status'=>'T02']);
        }else{
            $pena->update(['kode_status'=>'T03']);
        }
    }
}
