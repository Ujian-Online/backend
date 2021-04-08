<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Soal extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'unit_kompetensi_id',
        'asesor_id',
        'question',
        'question_type',
        'max_score',
        'answer_essay',
        'answer_option'
    ];

    public function SoalPilihanGanda()
    {
        return $this->hasMany('App\SoalPilihanGanda', 'soal_id', 'id')->orderBy('label', 'ASC');
    }

    public function UnitKompetensi()
    {
        return $this->hasOne('App\UnitKompetensi', 'id', 'unit_kompetensi_id');
    }
}
