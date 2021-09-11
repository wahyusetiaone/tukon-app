<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;
    //disable retrun id = int
    public $incrementing = false;

    protected $fillable = [
        'expiry_date'
    ];

    protected $casts = [
        'available_banks' => 'array',
        'available_retail_outlets' => 'array',
        'available_ewallets' => 'array',
        'items' => 'array'
    ];

    public function pembayaran(){
        return $this->belongsTo(Pembayaran::class, 'kode_pembayaran', 'id');
    }

}
