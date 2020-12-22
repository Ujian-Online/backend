<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UjianAsesiAsesor extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'asesi_id',
        'asesor_id',
        'ujian_jadwal_id',
        'sertifikasi_id',
        'order_id',
        'status',
        'is_kompeten',
        'final_score_percentage',
    ];
}
