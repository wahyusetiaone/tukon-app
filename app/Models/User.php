<?php

namespace App\Models;

use App\Notifications\VerifyApiEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Concerns\HasEvents;
use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasEvents;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'google_id',
        'name',
        'email',
        'email_verified_at',
        'no_hp',
        'no_hp_verified_at',
        'kode_role',
        'kode_user',
        'password',
        'registration_use',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'no_hp_verified_at' => 'datetime',
    ];

    public function sendApiEmailVerificationNotification()
    {
        $this->notify(new VerifyApiEmail);
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new \App\Notifications\MailResetPasswordNotification($token));
    }

    public function role()
    {
        return $this->belongsTo(Roles::class,'kode_role', 'id');
    }

    public function hasRole($roles)
    {
        $this->have_role = $this->getUserRole();

        if(is_array($roles)){
            foreach($roles as $need_role){
                if($this->cekUserRole($need_role)) {
                    return true;
                }
            }
        } else{
            return $this->cekUserRole($roles);
        }
        return false;
    }
    private function getUserRole()
    {
        return $this->role()->getResults();
    }

    private function cekUserRole($role)
    {
        return (strtolower($role)==strtolower($this->have_role->nama_role)) ? true : false;
    }

    public function scopeHasEmail($query){
        return $query->whereNotNull('email');
    }

    public function scopeHasNoHp($query){
        return $query->whereNotNull('no_hp');
    }

    public function scopeIsVerifiedEmail($query){
        return $query->whereNotNull('email_verified_at');
    }

    public function scopeIsVerifiedNoHp($query){
        return $query->whereNotNull('no_hp_verified_at');
    }

    //relation

    public function tukang()
    {
        return $this->hasOne(Tukang::class, 'id', 'kode_user');
    }

    public function client()
    {
        return $this->hasOne(Clients::class, 'id', 'kode_user');
    }

    public function admin()
    {
        return $this->hasOne(Admin::class, 'id', 'kode_user');
    }

    public function ban(){
        return $this->hasOne(Ban::class, 'user_id', 'id');
    }

    public function pre(){
        return $this->hasOne(PreRegistrationAdmin::class, 'email', 'email');
    }
}
