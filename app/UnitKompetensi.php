<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class UnitKompetensi extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'kode_unit_kompetensi',
        'title',
        'sub_title',
        'jenis_standar'
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
     * Relation to Table Sertifikasi Unit Kompetensi Element
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function UKElement()
    {
        return $this->hasMany('App\UnitKompetensiElement', 'unit_kompetensi_id', 'id');
    }
}
