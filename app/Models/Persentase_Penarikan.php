<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Persentase_Penarikan extends Model
{
    use HasFactory;

    public function history_penarikan(){
        return $this->belongsTo(Transaksi_Penarikan::class, 'id','kode_persentase_penarikan');
    }
}
