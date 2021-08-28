<?php
use App\Models\Tukang as Tukang;
use App\Models\PenarikanDana as PenarikanDana;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

if(!function_exists("verificationBeforePenarikan")) {
    function verificationBeforePenarikan($id, $kode_penarikan) {

        $verifikasi = ['status' => false];

        $hasTukangBankAccount = Tukang::whereId($id)
            ->whereNotNull('no_rekening')
            ->whereNotNull('atas_nama_rekening')
            ->whereNotNull('bank')
            ->exists();

        $hasUploadProgressToday = PenarikanDana::whereHas('project.progress.onprogress', function ($q){
            $q->whereDate('created_at', DB::raw('CURDATE()'));
        })->whereId($kode_penarikan)->exists();

        if (!$hasTukangBankAccount){
            $verifikasi['status'] = true;
            $verifikasi['message']['bank'] = 'Mohon untuk mengisi Nomor Rekening, Atas Nama, dan Bank yang akan digunakan transaksi pada menu "Profile".';
        }

        if (!$hasUploadProgressToday){
            $verifikasi['status'] = true;
            $verifikasi['message']['progress'] = 'Mohon maaf hari ini anda belum melakukan upload progress, mohon untuk melakukan upload progress terlebih dahulu !';
        }


        return $verifikasi;
    }
}

