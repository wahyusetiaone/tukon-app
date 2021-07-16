<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
      "kode_status",
    ];

    public function pembayaran(){
        return $this->belongsTo(Pembayaran::class, 'kode_pembayaran', 'id');
    }
}
