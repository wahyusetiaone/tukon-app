<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PemasukanAplikasi extends Model
{
    use HasFactory;

    protected $fillable = [
        'deep_id',
        'keterangan',
        'jumlah'
    ];
}
