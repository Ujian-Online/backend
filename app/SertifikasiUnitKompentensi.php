<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class SertifikasiUnitKompentensi extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order',
        'sertifikasi_id',
        'kode_unit_kompetensi',
        'title',
        'sub_title',
    ];

    /**
     * Relation to Table Sertifikasi
     *
     * @return HasOne
     */
    public function Sertifikasi()
    {
        return $this->hasOne('App\Sertifikasi');
    }
}
