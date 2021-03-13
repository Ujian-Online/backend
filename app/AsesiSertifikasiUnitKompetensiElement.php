<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class AsesiSertifikasiUnitKompetensiElement extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'asesi_id',
        'unit_kompetensi_id',
        'desc',
        'upload_instruction',
        'is_verified',
        'verification_note',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'is_verified'   => 'boolean'
    ];

    /**
     * Relation to Table User Asesi
     *
     * @return HasOne
     */
    public function Asesi()
    {
        return $this->hasOne('App\UserAsesi', 'id', 'asesi_id');
    }

    /**
     * Relation to Table Sertifikasi Unit Kompentensi
     *
     * @return HasOne
     */
    public function UnitKompentensi()
    {
        return $this->hasOne('App\SertifikasiUnitKompentensi', 'id', 'unit_kompetensi_id');
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
