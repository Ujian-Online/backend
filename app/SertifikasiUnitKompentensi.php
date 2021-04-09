<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class SertifikasiUnitKompentensi extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'sertifikasi_id',
        'unit_kompetensi_id',
        'order'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'order' => 'integer',
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
     * Relation to Table Unit Kompetensi
     *
     * @return HasOne
     */
    public function UnitKompetensi()
    {
        return $this->hasOne('App\UnitKompetensi', 'id', 'unit_kompetensi_id');
    }
}
