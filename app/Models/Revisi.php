<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Revisi extends Model
{
    use HasFactory;

    public function pin()
    {
        return $this->$this->belongsTo(Pin::class, 'kode_penawaran', 'kode_penawaran');
    }
}
