<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rate extends Model
{
    use HasFactory;

    public function tukang(){
        return $this->belongsTo(Tukang::class,'kode_tukang', 'id');
    }
}
