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
        'media_url',
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
     * Relation to Table Asesi
     *
     * @return HasOne
     */
    public function asesi()
    {
        return $this->hasOne('App\Asesi');
    }

    public function unitkompentensi()
    {

    }
}
