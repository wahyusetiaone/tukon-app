<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VoteRate extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_project',
        'kode_tukang',
        'value'
    ];

    public function tukang(){
        return $this->belongsTo(Tukang::class, 'kode_tukang','id');
    }

    public function project(){
        return $this->belongsTo(Project::class, 'kode_project', 'id');
    }
}
