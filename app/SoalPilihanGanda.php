<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SoalPilihanGanda extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'soal_id',
        'option',
        'label',
    ];
}

