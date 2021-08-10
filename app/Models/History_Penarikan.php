<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class History_Penarikan extends Model
{
    use HasFactory;

    public function penarikan(){
        return $this->belongsTo(PenarikanDana::class, 'kode_penarikan','id');
    }

    public function persentase(){
        return $this->hasOne(Persentase_Penarikan::class, '','kode_persentase_penarikan');
    }
}
