<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TukBank extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tuk_id',
        'bank_name',
        'account_number',
        'account_name',
    ];
}
