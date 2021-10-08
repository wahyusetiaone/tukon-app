<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

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
        'expired_at',
    ];


    public function scopeGetExpiredNow($query){
        return $query
            ->where('expired_at','<=', Carbon::now())
            ->where('kode_penawaran','=', null)
            ->where('status','=', 'N01')
            ->get();
    }

    public function pengajuan()
    {
        return $this->belongsTo(Pengajuan::class, 'kode_pengajuan', 'id')->withTrashed();
    }

    public function tukang()
    {
        return $this->hasOne(Tukang::class, 'id', 'kode_tukang');
    }

    public function penawaran()
    {
        return $this->hasOne(Penawaran::class, 'kode_pin', 'id')->withTrashed();
    }

    public function pembayaran()
    {
        return $this->hasOne(Pembayaran::class, 'kode_pin', 'id');
    }

    public function revisi()
    {
        return $this->hasMany(Revisi::class, 'kode_penawaran', 'kode_penawaran')->orderByDesc('updated_at');
    }
}
