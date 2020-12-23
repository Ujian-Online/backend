<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SertifikasiTuk extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'sertifikasi_id',
        'tuk_id',
        'tuk_price_baru',
        'tuk_price_perpanjang',
    ];
}
