<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SoalPaket extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'sertifikasi_id',
    ];
}
