<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sertifikasi extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nomor_skema',
        'title',
        'original_price_baru',
        'original_price_perpanjang',
        'jenis_sertifikasi',
        'is_active',
    ];
}
