<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Sertifikasi extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nomor_skema',
        'title',
        'original_price_baru',
        'original_price_perpanjang',
        'is_active',
    ];

    /**
     * Relation Table to SertifikasiTuk
     *
     * @return BelongsToMany
     */
    public function SertifikasiTuk()
    {
        return $this->hasMany('App\SertifikasiTuk');
    }
}
