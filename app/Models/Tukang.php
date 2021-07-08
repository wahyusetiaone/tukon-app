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
        'kota',
        'alamat'
    ];

    public function user(){
        return $this->belongsTo(User::class, 'id', 'kode_user');
    }

    public function produk(){
        return $this->hasMany(Produk::class, 'kode_tukang', 'id');
    }

}
