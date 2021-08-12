<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenarikanDana extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_project',
        'total_dana',
        'kode_limitasi',
        'limitasi',
        'persentase_penarikan',
        'penarikan',
        'sisa_penarikan',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class, 'kode_project', 'id');
    }

    public function limitasi_penarikan(){
        return $this->hasOne(Limitasi_Penarikan::class, 'id','kode_limitasi');
    }

    public function transaksi_penarikan()
    {
        return $this->hasMany(Transaksi_Penarikan::class, 'kode_penarikan', 'id');
    }
}
