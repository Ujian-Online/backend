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
     * Relation to Table User Asesi
     *
     * @return HasOne
     */
    public function Asesi()
    {
        return $this->hasOne('App\UserAsesi', 'id', 'asesi_id');
    }

    /**
     * Relation to Table Sertifikasi
     *
     * @return HasOne
     */
    public function Sertifikasi()
    {
        return $this->hasOne('App\Sertifikasi');
    }

    /**
     * Relation to Table Sertifikasi Unit Kompentensi
     *
     * @return HasOne
     */
    public function UnitKompetensi()
    {
        return $this->hasOne('App\SertifikasiUnitKompentensi', 'id', 'unit_kompetensi_id');
    }
}
