<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserAsesiCustomData extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'asesi_id',
        'title',
        'input_type',
        'value',
        'is_verified',
        'verification_note',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'is_verified' => 'boolean'
    ];
}
