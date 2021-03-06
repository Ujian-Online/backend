<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UjianJadwal extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tanggal',
        'jam_mulai',
        'jam_berakhir',
        'title',
        'description',
    ];
}
