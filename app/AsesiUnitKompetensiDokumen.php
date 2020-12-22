<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AsesiUnitKompetensiDokumen extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_asesi_id',
        'unit_kompetensi_id',
        'order',
        'sertifikasi_id',
        'kode_unit_kompetensi',
        'title',
        'sub_title',
    ];
}
