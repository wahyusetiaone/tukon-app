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

    public function scopeAmbilBonus($query, $only, $auth)
    {
        switch ($only){
            case 'active' :
                $selector = 'BA01';
                break;
            case 'pandding' :
                $selector = 'BA02';
                break;
            case 'success' :
                $selector = 'BA03';
                break;
            case 'ditolak' :
                $selector = 'BA04';
                break;
            case 'batal' :
                $selector = 'BA05';
                break;
        }
        return $query->with('project.pembayaran.pin.pengajuan', 'project.pembayaran.pin.tukang', 'project.pembayaran.pin.tukang.user')
            ->whereHas('project', function ($q){
                $q->where('kode_status', 'ON05');
            })
            ->where('kode_status', $selector)
            ->where('admin_id', $auth)->paginate(10);
    }

    public function admin(){
        return $this->belongsTo(Admin::class, 'admin_id', 'id');
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'kode_project', 'id');
    }

    public function transaksi()
    {
        return $this->hasMany(Transaksi_Pencairan_Bonus::class, 'bonus_admin_id', 'id');
    }
}
