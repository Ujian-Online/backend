<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class SoalPaketItem extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'soal_paket_id',
        'soal_id',
    ];

    /**
     * Relation to Database Soal Paket
     *
     * @return HasOne
     */
    public function SoalPaket()
    {
        return $this->hasOne('App\SoalPaket', 'id', 'soal_paket_id');
    }

    /**
     * Relation to Database Soal
     *
     * @return HasOne
     */
    public function Soal()
    {
        return $this->hasOne('App\Soal', 'id', 'soal_id');
    }
}
