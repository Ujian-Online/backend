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
        'soal_id',
        'asesi_id',
        'question',
        'question_type',
        'answer_essay',
        'answer_option',
        'urutan',
        'user_answer',
        'catatan_asesor',
        'max_score',
        'final_score',
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
     * Relation to Table User Asesi
     *
     * @return HasOne
     */
    public function Asesi()
    {
        return $this->hasOne('App\UserAsesi', 'id', 'asesi_id');
    }
}
