<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Limitasi_Penarikan extends Model
{
    use HasFactory;

    public function penarikan(){
        return $this->belongsTo(PenarikanDana::class,'id','kode_limitasi');
    }
}
