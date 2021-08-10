<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OnProgress extends Model
{
    use HasFactory;

    public function progress(){
        return $this->belongsTo(Progress::class, 'kode_progress', 'id');
    }

    public function doc(){
        return $this->hasMany(DocumentationProgress::class, 'kode_on_progress', 'id');
    }
}
