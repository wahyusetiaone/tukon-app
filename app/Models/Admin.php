<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'nomor_telepon',
        'path_foto',
        'alamat',
        'provinsi',
        'kota'
    ];

    public function user(){
        return $this->belongsTo(User::class, 'id', 'kode_user');
    }

    public function has_cabang(){
        return $this->hasMany(HasCabang::class, 'admin_id', 'id');
    }

    public function verification(){
        return $this->hasMany(VerificationTukang::class, 'admin_id', 'id');
    }
}
