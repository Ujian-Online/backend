<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class AsesiUnitKompetensiDokumen extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'asesi_id',
        'unit_kompetensi_id',
        'order',
        'sertifikasi_id',
        'kode_unit_kompetensi',
        'title',
        'sub_title',
    ];

    /**
     * Relation to Table User
     *
     * @return HasOne
     */
    public function User()
    {
        return $this->hasOne('App\User', 'id', 'asesi_id');
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
     * Relation to Table Sertifikasi Unit Kompentensi
     *
     * @return HasOne
     */
    public function AsesiSertifikasiUnitKompetensiElement()
    {
        return $this->hasMany('App\AsesiSertifikasiUnitKompetensiElement', 'unit_kompetensi_id', 'unit_kompetensi_id');
    }

    /**
     * Get All Media For APL02
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function Media()
    {
        return $this->hasMany('App\AsesiSUKElementMedia', 'asesi_suk_element_id', 'id');
    }
}
