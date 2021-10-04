<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BonusAdminCabang extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_project',
        'admin_id',
        'dialihkan',
        'bonus',
        'kode_status'
    ];

    public function transaksi(){
        return $this->hasMany(Transaksi_Pencairan_Bonus::class, 'bonus_admin_id', 'id');
    }
}
