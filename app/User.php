<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @see String $type Detail List Type Cek di: config('options.user_type')
     * @see String $status Detail List Type Cek di: onfig('options.user_status')
     *
     * @var array
     */
    protected $fillable = [
        'email',
        'password',
        'type', // see config('options.user_type')
        'status',
        'media_url', // profile picture
        'media_url_sign_user', // signature
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_active' => 'boolean'
    ];

    /**
     * Relation to Table UserAsesi
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function Asesi()
    {
        return $this->hasOne('App\UserAsesi', 'user_id', 'id');
    }

    /**
     * Relation to Table UserAsesor
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function Asesor()
    {
        return $this->hasOne('App\UserAsesor', 'user_id', 'id');
    }

    /**
     * Relation to Table TUK
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function Tuk()
    {
        return $this->hasOne('App\UserTuk', 'user_id', 'id');
    }
}
