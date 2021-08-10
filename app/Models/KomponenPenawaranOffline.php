<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KomponenPenawaranOffline extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_penawaran_offline',
        'nama_komponen',
        'harga',
        'merk_type',
        'spesifikasi_teknis',
        'satuan',
        'total_unit'
    ];

    public function penawaran()
    {
        return $this->hasOne(PenawaranOffline::class, 'kode_penawaran_offline', 'id');
    }
}
