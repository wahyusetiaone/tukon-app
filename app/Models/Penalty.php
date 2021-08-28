<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penalty extends Model
{
    use HasFactory;

    public function pengembalian(){
        return $this->belongsTo(PengembalianDana::class, 'id', 'kode_penalty');
    }
}
