<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sistem_Penarikan_Dana extends Model
{
    use HasFactory;

    function penawaran(){
        return $this->belongsTo(Penawaran::class, 'id', 'kode_spd');
    }
}
