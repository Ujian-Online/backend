<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class UserTuk extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'tuk_id'
    ];

    /**
     * Relation to Table User
     *
     * @return HasOne
     */
    public function User()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }

    /**
     * Relation to Table TUK
     *
     * @return HasOne
     */
    public function Tuk()
    {
        return $this->hasOne('App\Tuk', 'id', 'tuk_id');
    }
}
