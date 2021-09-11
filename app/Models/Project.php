<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        "kode_status",
        "persentase_progress"
    ];

    public function pembayaran(){
        return $this->belongsTo(Pembayaran::class, 'kode_pembayaran', 'id');
    }

    public function progress(){
        return $this->hasOne(Progress::class, 'kode_project', 'id');
    }

    public function penarikan(){
        return $this->hasOne(PenarikanDana::class, 'kode_project','id');
    }

    public function pengembalian(){
        return $this->hasOne(PengembalianDana::class, 'kode_project', 'id');
    }

    public function voterate(){
        return $this->hasOne(VoteRate::class, 'kode_project', 'id');
    }
}
