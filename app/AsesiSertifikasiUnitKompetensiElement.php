<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AsesiSertifikasiUnitKompetensiElement extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_asesi_id',
        'unit_kompetensi_id',
        'desc',
        'upload_instruction',
        'media_url',
        'is_verified',
        'verification_note',
    ];
}
