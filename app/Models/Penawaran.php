<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

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
        'kode_spd',
        'kode_bpa',
        'kode_bac',
        'keuntungan',
        'harga_total',
        'harga',
        'kode_status',
    ];

    public function pin(){
        return $this->belongsTo(Pin::class, 'kode_pin', 'id');
    }

    public function spd(){
        return $this->hasOne(Sistem_Penarikan_Dana::class, 'id', 'kode_spd');
    }

    public function history_penawaran(){
        return $this->hasMany(History_Penawaran::class, 'kode_penawaran', 'id');
    }

    public function bpa(){
        return $this->hasOne(BPA::class, 'id', 'kode_bpa');
    }

    public function bac(){
        return $this->hasOne(BACabang::class, 'id', 'kode_bac');
    }

    public function getTotalHargaKomponen() {
        return $this->komponen()->sum(DB::raw('harga'));
    }

    public function nego(){
        return $this->hasOne(NegoPenawaran::class, 'kode_penawaran', 'id');
    }
}
