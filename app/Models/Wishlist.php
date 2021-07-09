<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    use HasFactory;

    public function client()
    {
        return $this->belongsTo(Clients::class, 'id', 'kode_client');
    }

    public function produk(){
        return $this->hasOne(Produk::class, 'id', 'kode_produk');
    }
}
