<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
        'is_active',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'original_price_baru',
        'original_price_perpanjang',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'is_active' => 'boolean',
        'original_price_baru' => 'float',
        'original_price_perpanjang' => 'float',
    ];

    /**
     * Relation Table to SertifikasiTuk
     *
     * @return HasMany
     */
    public function SertifikasiTuk()
    {
        return $this->hasMany('App\SertifikasiTuk');
    }

    /**
     * Relation to Table Sertifikasi Unit Kompentensi
     *
     * @return HasMany
     */
    public function SertifikasiUnitKompentensi()
    {
        return $this->hasMany('App\SertifikasiUnitKompentensi');
    }

    /**
     * Relation to Table Unit Kompetensi
     *
     * @return HasMany
     */
    public function UnitKompetensi()
    {
        return $this->hasMany('App\UnitKompetensi');
    }

    /**
     * Relation to Table Sertifikasi Unit Kompentensi
     *
     * @return HasMany
     */
    public function AsesiUnitKompetensiDokumen()
    {
        return $this->hasMany('App\AsesiUnitKompetensiDokumen', 'sertifikasi_id', 'id');
    }
}
