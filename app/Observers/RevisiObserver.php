<?php

namespace App\Observers;

use App\Models\History_Penawaran;
use App\Models\Penawaran;
use App\Models\Pin;
use App\Models\Revisi;
use Illuminate\Support\Facades\Log;

class RevisiObserver
{
    /**
     * Handle the Revisi "created" event.
     *
     * @param \App\Models\Revisi $revisi
     * @return void
     */
    public function created(Revisi $revisi)
    {
        if (isset($revisi->kode_penawaran)) {
            $id = $revisi->id;
            $ko = $revisi->kode_penawaran;
            $penawaran = Penawaran::find($ko)->with('pin')->firstOrFail();
            $revisi = Revisi::where(['kode_penawaran' => $ko])->orderBy('created_at', 'DESC')->get();
            $revisi_ke = $revisi->count();
            Log::info($revisi_ke);
            $h_new_revisi = $revisi->skip(1)->first();
            //ubah kode_sattus pin
            Pin::where(['id' => $penawaran->kode_pin])->update(['kode_revisi'=>$id]);
            //ubah status penawaran
            Penawaran::where(['id' => $ko])->update(['kode_status'=>'T02A']);
            //create history
            $h_penawaran = new History_Penawaran();
            $h_penawaran->kode_penawaran = $penawaran->id;
            $h_penawaran->kode_pin = $penawaran->kode_pin;
            $h_penawaran->keuntungan = $penawaran->keuntungan;
            $h_penawaran->harga_total = $penawaran->harga_total;
            $h_penawaran->kode_status = $penawaran->kode_status;
            $h_penawaran->revisi = $revisi_ke;
            $h_penawaran->save();
            //create revisi
            if ($revisi_ke > 1){
                Revisi::where('id', $id)->update([
                    'kode_history_penawaran' => $h_penawaran->id,
                    'old_revisi' => $h_new_revisi->id
                ]);
            }else{
                Revisi::where('id', $id)->update([
                    'kode_history_penawaran' => $h_penawaran->id
                ]);
            }
        }
    }
}
