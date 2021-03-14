<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AsesiSUKElementMedia extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'asesi_id',
        'asesi_suk_element_id',
        'description',
        'media_url',
    ];
}
