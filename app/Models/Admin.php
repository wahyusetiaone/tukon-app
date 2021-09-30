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
}
