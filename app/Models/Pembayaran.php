<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;

    public function pin(){
        return $this->belongsTo(Pin::class, 'kode_pin', 'id');
    }

    public function transaksi_pembayaran(){
        return $this->hasMany(Transaksi_Pembayaran::class, 'kode_pembayaran','id');
    }
}
