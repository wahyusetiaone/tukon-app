<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi_Penarikan extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_penarikan',
        'kode_persentase_penarikan',
        'penarikan',
        'sisa_penarikan',
        'kode_status'
    ];

    public function penarikan_dana(){
        return $this->belongsTo(PenarikanDana::class, 'kode_penarikan','id');
    }

    public function persentase(){
        return $this->hasOne(Persentase_Penarikan::class, 'id','kode_persentase_penarikan');
    }
}
