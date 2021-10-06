<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BACabang extends Model
{
    use HasFactory, SoftDeletes;

    public function penawaran(){
        return $this->belongsTo(Penawaran::class, 'id', 'kode_bac');
    }
}
