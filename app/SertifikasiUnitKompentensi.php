<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
}
