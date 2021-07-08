<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clients extends Model
{
    use HasFactory;    /**
 * The attributes that are mass assignable.
 *
 * @var array
 */
    protected $fillable = [
        'id',
        'nomor_telepon',
        'alamat'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'kode_user', 'id');
    }

    public function wishlist()
    {
        return $this->hasMany(Wishlist::class, 'kode_client', 'id');
    }
}
