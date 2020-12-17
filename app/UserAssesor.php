<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserAssesor extends Model
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
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'expired_date' => 'date',
    ];

    /**
     * Relation to Table User
     */
    public function User()
    {
        return $this->hasOne('App\User');
    }
}
