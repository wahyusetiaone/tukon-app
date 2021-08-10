<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Progress extends Model
{
    use HasFactory;

    public function project(){
        return $this->belongsTo(Project::class,'kode_project', 'id');
    }

    public function onprogress(){
        return $this->hasMany(OnProgress::class,'kode_progress', 'id');
    }
}
