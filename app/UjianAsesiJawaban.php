<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class UjianAsesiJawaban extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'ujian_asesi_asesor_id',
        'soal_id',
        'asesi_id',
        'question',
        'question_type',
        'answer_essay',
        'answer_option',
        'options_label',
        'urutan',
        'user_answer',
        'catatan_asesor',
        'max_score',
        'final_score',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'options_label' => 'array'
    ];

    /**
     * Relation to Table Soal
     *
     * @return HasOne
     */
    public function Soal()
    {
        return $this->hasOne('App\Soal', 'id', 'soal_id');
    }

    /**
     * Relation to Table User
     *
     * @return HasOne
     */
    public function Asesi()
    {
        return $this->hasOne('App\User', 'id', 'asesi_id');
    }
}
