<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class UnitKompetensiElement extends Model
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

    /**
     * Relation to Table Sertifikasi Unit Kompentensi
     *
     * @return HasOne
     */
    public function UnitKompetensi()
    {
        return $this->hasOne('App\UnitKompetensi', 'id', 'unit_kompetensi_id');
    }
}
