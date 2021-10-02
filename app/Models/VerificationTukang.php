<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VerificationTukang extends Model
{
    use HasFactory;

    protected $fillable = [
      'tukang_id',
      'admin_id',
      'nama_tukang',
      'no_hp',
      'email',
      'alamat',
      'koordinat',
    ];

    public function tukang(){
        return $this->belongsTo(Tukang::class, 'tukang_id', 'id');
    }

    public function berkas(){
        return $this->hasOne(BerkasVerificationTukang::class, 'verificationtukang_id', 'id');
    }
}
