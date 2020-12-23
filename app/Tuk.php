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
}
