<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

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

    /**
     * Relation to Database Soal
     *
     * @return HasOne
     */
    public function Soal()
    {
        return $this->hasOne('App\Soal', 'id', 'soal_id');
    }
}

