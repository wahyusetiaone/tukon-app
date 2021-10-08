<?php

namespace App\Observers;

use App\Models\Invoice;
use App\Models\Pembayaran;

class InvoiceObserver
{
    /**
     * Handle the User "created" event.
     *
     * @param \App\Models\Invoice $invoice
     * @return void
     */
    public function created(Invoice $invoice)
    {
        if ($invoice->payment_offline){
            $startDate = time();
            $expiry = date('Y-m-d H:i:s', strtotime('+1 day', $startDate));
            $invoice->update(['expiry_date' => $expiry]);
        }
    }
    /**
     * Handle the User "created" event.
     *
     * @param \App\Models\Invoice $invoice
     * @return void
     */
    public function updated(Invoice $invoice)
    {
        if ($invoice->status == 'PAID'){
            $pembayaran = Pembayaran::where('id',$invoice->kode_pembayaran)->first();
            $pembayaran->kode_status = 'P03';
            $pembayaran->save();
        }
        if ($invoice->status == 'EXPIRED'){
            $pembayaran = Pembayaran::where('id',$invoice->kode_pembayaran)->first();
            $pembayaran->kode_status = 'P02';
            $pembayaran->save();
        }
    }
}
