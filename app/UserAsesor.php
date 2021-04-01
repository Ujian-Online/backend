<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserAsesor extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @see String $type Detail List Type Cek di: config('options.user_type')
     * @see String $status Detail List Type Cek di: onfig('options.user_status')
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'met', 'name', 'expired_date', 'address',
    ];

    /**
     * Relation to Table User
     */
    public function User()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }
}
