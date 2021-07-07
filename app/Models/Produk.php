<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    protected $fillable = ['kode_tukang','nama_produk', 'range_min', 'range_max', 'diskripsi', 'multipath' , 'path'];

    public function tukang(){
        return $this->belongsTo(Tukang::class, 'id', );
    }
}
