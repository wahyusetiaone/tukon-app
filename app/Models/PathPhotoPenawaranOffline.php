<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PathPhotoPenawaranOffline extends Model
{
    use HasFactory;

    public function penawaran(){
        return $this->hasOne(PenawaranOffline::class, 'kode_penawaran_offline', 'id');
    }
}
