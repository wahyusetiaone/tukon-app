<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentationProgress extends Model
{
    use HasFactory;
    protected $fillable = [
        'note_progress'
    ];

    public function onprogress(){
        return $this->belongsTo(OnProgress::class, 'kode_on_progress', 'id');
    }
}
