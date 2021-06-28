<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

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

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'jenis_pengalaman' => 'boolean'
    ];

    /**
     * Relation to Table User Asesi
     *
     * @return HasOne
     */
    public function UserAsesi()
    {
        return $this->hasOne('App\User', 'id', 'asesi_id');
    }

    /**
     * Relation to Table User Asesor
     *
     * @return HasOne
     */
    public function UserAsesor()
    {
        return $this->hasOne('App\User', 'id', 'asesor_id');
    }
}
