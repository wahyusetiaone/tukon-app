<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NegoPenawaran extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_penawaran',
        'harga_nego'
    ];

    public function penawaran(){
        return $this->belongsTo(Penawaran::class, 'kode_penawaran', 'id');
    }
}
