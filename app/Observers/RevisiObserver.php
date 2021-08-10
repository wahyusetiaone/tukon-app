<?php

namespace App\Observers;

use App\Models\History_Komponen;
use App\Models\History_Penawaran;
use App\Models\Komponen;
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
            $penawaran = Penawaran::where('id',$ko)->with('pin','komponen')->firstOrFail();
            $revisi = Revisi::where(['kode_penawaran' => $ko])->orderBy('created_at', 'DESC')->get();
            $revisi_ke = $revisi->count();
            Log::info($revisi_ke);
            $h_new_revisi = $revisi->skip(1)->first();
            //ubah kode_sattus pin
            Pin::where(['kode_penawaran' => $penawaran->id])->update(['kode_revisi'=>$id]);
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
            //create history_komponen
            foreach ($penawaran->komponen as $item){
                $h_komponen = new History_Komponen();
                $h_komponen->kode_history_penawaran = $h_penawaran->id;
                $h_komponen->nama_komponen = $item->nama_komponen;
                $h_komponen->harga = $item->harga;
                $h_komponen->merk_type = $item->merk_type;
                $h_komponen->spesifikasi_teknis = $item->spesifikasi_teknis;
                $h_komponen->satuan = $item->satuan;
                $h_komponen->total_unit = $item->total_unit;
                $h_komponen->save();
            }
        }
    }
}
