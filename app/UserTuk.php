<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
     */
    public function User()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }
}
