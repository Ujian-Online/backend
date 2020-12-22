<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SoalUnitKompetensi extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'soal_id',
        'unit_kompetensi_id',
    ];
}
