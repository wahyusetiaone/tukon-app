<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi_Pengembalian extends Model
{
    use HasFactory;

    protected $fillable = [
        'nomor_rekening',
        'atas_nama_rekening',
        'bank',
        'kode_penalty',
        'kode_status',
        'catatan_penolakan',
        'path_bukti',
    ];

    public function pengembalian_dana(){
        return $this->belongsTo(PengembalianDana::class, 'kode_pengembalian_dana', 'id')->orderByDesc('created_at');
    }
}
