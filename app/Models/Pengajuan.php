<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pengajuan extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'kode_client',
        'nama_proyek',
        'diskripsi_proyek',
        'alamat',
        'path',
        'multipath',
        'offline',
        'range_min',
        'range_max',
        'deadline',
        'kode_status',
    ];

    public function pin(){
        return $this->hasMany(Pin::class, 'kode_pengajuan', 'id');
    }

    public function client(){
        return $this->belongsTo(Clients::class,'kode_client','id');
    }

    public function berkas(){
        return $this->hasMany(Berkas::class, 'kode_pengajuan', 'id');
    }
}
