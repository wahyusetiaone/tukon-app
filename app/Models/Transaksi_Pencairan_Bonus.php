<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi_Pencairan_Bonus extends Model
{
    use HasFactory;

    protected $fillable = [
        'bonus_admin_id',
        'pencairan',
        'catatan_penolakan',
        'bukti_tf_admin',
        'kode_status'
    ];

    public function bonus(){
        return $this->belongsTo(BonusAdminCabang::class,'bonus_admin_id', 'id');
    }
}
