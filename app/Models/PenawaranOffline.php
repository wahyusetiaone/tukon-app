<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenawaranOffline extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_tukang',
        'nama_client',
        'email_client',
        'nomor_telepon_client',
        'alamat_client',
        'nama_proyek',
        'diskripsi_proyek',
        'alamat_proyek',
        'range_min',
        'range_max',
        'keuntungan',
        'deadline',
        'harga_total',
    ];

    public function tukang(){
       return $this->belongsTo(Tukang::class, 'kode_tukang', 'id');
    }

    public function komponen(){
       return $this->hasMany(KomponenPenawaranOffline::class, 'kode_penawaran_offline','id');
    }

    public function path(){
        return $this->hasMany(PathPhotoPenawaranOffline::class, 'kode_penawaran_offline', 'id');
    }
}
