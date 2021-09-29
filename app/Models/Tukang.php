<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tukang extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'nomor_telepon',
        'path_icon',
        'provinsi',
        'kota',
        'alamat',
        'kode_lokasi',
        'no_rekening',
        'atas_nama_rekening',
        'bank',
    ];

    public function user(){
        return $this->belongsTo(User::class, 'id', 'kode_user');
    }

    public function pin(){
        return $this->belongsTo(Pin::class, 'id', 'kode_tukang');
    }

    public function produk(){
        return $this->hasMany(Produk::class, 'kode_tukang', 'id');
    }

    public function penawaranoffline(){
        return $this->hasMany(PenawaranOffline::class, 'tukang', 'id');
    }

    public function rating(){
        return $this->hasMany(Rate::class, 'kode_tukang', 'id')->orderBy('value_rate', 'desc');
    }

    public function voterate(){
        return $this->hasMany(VoteRate::class, 'kode_tukang', 'id');
    }

    public function foto_kantor(){
        return $this->hasMany(TukangFotoKantor::class, 'tukang_id', 'id');
    }
}
