<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TukangFotoKantor extends Model
{
    use HasFactory;

    protected $fillable =[
      'tukang_id',
      'path',
      'original_name'
    ];

    public function tukang(){
        return $this->belongsTo(Tukang::class, 'tukang_id', 'id');
    }
}
