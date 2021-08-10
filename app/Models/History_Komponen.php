<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class History_Komponen extends Model
{
    use HasFactory;
    protected $fillable = [
        'kode_pin',
        'kode_penawaran',
        'keuntungan',
        'harga_total',
        'kode_status',
    ];
}
