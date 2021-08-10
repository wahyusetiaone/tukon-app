<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Penawaran extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'kode_pin',
        'kode_bpa',
        'keuntungan',
        'harga_total',
        'kode_status',
    ];

    public function pin(){
        return $this->belongsTo(Pin::class, 'id', 'kode_penawaran');
    }

    public function komponen(){
        return $this->hasMany(Komponen::class, 'kode_penawaran', 'id');
    }

    public function history_penawaran(){
        return $this->hasMany(History_Penawaran::class, 'kode_penawaran', 'id');
    }

    public function bpa(){
        return $this->hasOne(BPA::class, 'id', 'kode_bpa');
    }
}
