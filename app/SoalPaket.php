<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

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
        'asesor_id',
        'durasi_ujian',
    ];

    /**
     * Relation to Table Sertifikasi
     *
     * @return HasOne
     */
    public function Sertifikasi()
    {
        return $this->hasOne('App\Sertifikasi', 'id', 'sertifikasi_id');
    }

    /**
     * Relation to Table SoalPaketItem
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function SoalPaketItem()
    {
        return $this->hasMany('App\SoalPaketItem', 'soal_paket_id', 'id');
    }
}
