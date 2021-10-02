<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BerkasVerificationTukang extends Model
{
    use HasFactory;

    public function verification(){
        return $this->belongsTo(VerificationTukang::class, 'verificationtukang_id', 'id');
    }
}
