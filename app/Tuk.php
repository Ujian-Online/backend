<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tuk extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
        'title',
        'telp',
        'address',
        'type',
    ];

    /**
     * Relation to Table TukBank
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function Bank()
    {
        return $this->hasMany('App\TukBank');
    }
}
