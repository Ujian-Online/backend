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
        'question',
        'question_type',
        'max_score',
        'answer_essay',
        'answer_option'
    ];
}
