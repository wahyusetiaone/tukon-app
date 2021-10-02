<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cabang extends Model
{
    use HasFactory;

    public function tukang(){
        return $this->hasMany(Tukang::class, 'kota','kode_cabang');
    }

    public function has_cabang(){
        return $this->belongsTo(HasCabang::class, 'cabang_id', 'id');
    }
}
