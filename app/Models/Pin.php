<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pin extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'kode_pengajuan',
        'kode_tukang',
        'status',
    ];

    public function pengajuan(){
        return $this->belongsTo(Pengajuan::class, 'kode_pengajuan','id');
    }

    public function tukang(){
        return $this->hasOne(Tukang::class, 'id', 'kode_tukang');
    }

    public function penawaran(){
        return$this->hasOne(Penawaran::class, 'id', 'kode_penawaran');
    }

    public function pembayaran(){
        return$this->hasOne(Pembayaran::class, 'kode_pin', 'id');
    }
}
