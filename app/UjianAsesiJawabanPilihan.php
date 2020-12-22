<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UjianAsesiJawabanPilihan extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'option',
        'label',
    ];
}
