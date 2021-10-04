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
      'catatan',
    ];

    public function admin(){
        return $this->belongsTo(Admin::class, 'admin_id', 'id');
    }

    public function tukang(){
        return $this->belongsTo(Tukang::class, 'tukang_id', 'id');
    }

    public function berkas(){
        return $this->hasMany(BerkasVerificationTukang::class, 'verificationtukang_id', 'id');
    }
}
