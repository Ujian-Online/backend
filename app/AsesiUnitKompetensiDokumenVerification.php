<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AsesiUnitKompetensiDokumenVerification extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'asesi_id',
        'asesor_id',
        'sertifikasi_id',
        'recommendation',
        'jenis_pengalaman',
        'asesi_verification_date',
        'asesor_verification_date',
    ];
}
