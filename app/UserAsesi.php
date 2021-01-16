<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserAsesi extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'name',
        'address',
        'phone_number',
        'gender',
        'birth_place',
        'birth_date',
        'no_ktp',
        'pendidikan_terakhir',
        'has_job',
        'job_title',
        'job_address',
        'user_id_admin',
        'note_admin',
        'is_verified',
        'verification_note',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'gender'        => 'boolean',
        'birth_date'    => 'date',
        'has_job'       => 'boolean',
        'is_verified'   => 'boolean'
    ];
}
