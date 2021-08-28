<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengembalianDana extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_project',
        'jmlh_pengembalian_persentasi',
        'jmlh_pengembalian',
        'kode_status'
    ];

    public function project(){
        return $this->belongsTo(Project::class, 'kode_project', 'id');
    }

    public function transaksi(){
        return $this->hasMany(Transaksi_Pengembalian::class, 'kode_pengembalian_dana', 'id');
    }

    public function penalty(){
        return $this->hasOne(Penalty::class, 'id', 'kode_penalty');
    }
}
