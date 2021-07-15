<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi_Pembayaran extends Model
{
    use HasFactory;

    protected $fillable = [
      "note_transaksi",
    ];

    public function pembayaran(){
        return $this->belongsTo(Pembayaran::class,'kode_pembayaran','id');
    }
}
