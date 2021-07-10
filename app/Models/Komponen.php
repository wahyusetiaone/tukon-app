<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Komponen extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_komponen',
        'harga',
    ];

    public function penawaran(){
        return $this->belongsTo(Penawaran::class, 'kode_penawaran', 'id');
    }
}
