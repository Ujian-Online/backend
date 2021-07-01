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
        'jenis_ujian'
    ];

    /**
     * Convert Durasi Ujian
     * Dari Init (Number) Menit ke Time Format
     * Example 120 Minutes to 02:00:00
     *
     * @param $value
     * @return $void
     */
    public function setDurasiUjianAttribute($value)
    {
        $date = \Carbon\Carbon::now()->startOfDay();
        $dateWithMinutes = $date->addMinutes($value);

        $this->attributes['durasi_ujian'] = $dateWithMinutes->toTimeString();
    }

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
