<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UjianAsesiJawaban extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'soal_id',
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
}
