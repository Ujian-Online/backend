<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SertifikasiUnitKompetensiElement extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'unit_kompetensi_id',
        'desc',
        'upload_instruction',
    ];
}
