<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Berkas extends Model
{
    use HasFactory;

    public function pengajuan(){
        return $this->belongsTo(Pengajuan::class,'kode_pengajuan', 'id');
    }
}
