<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

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
        'soal_paket_id',
        'status',
        'is_kompeten',
        'final_score_percentage',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'is_kompeten' => 'boolean'
    ];

    /**
     * Relation to Table User Asesi
     *
     * @return HasOne
     */
    public function UserAsesi()
    {
        return $this->hasOne('App\User', 'id', 'asesi_id');
    }

    /**
     * Relation to Table User Asesor
     *
     * @return HasOne
     */
    public function UserAsesor()
    {
        return $this->hasOne('App\User', 'id', 'asesor_id');
    }

    /**
     * Relation to Table Ujian Jadwal
     *
     * @return HasOne
     */
    public function Ujianjadwal()
    {
        return $this->hasOne('App\UjianJadwal', 'id', 'ujian_jadwal_id');
    }

    /**
     * Relation to Table Sertifikasi
     *
     * @return HasOne
     */
    public function Sertifikasi()
    {
        return $this->hasOne('App\Sertifikasi', 'id', 'sertifikasi_id');
    }

    /**
     * Relation to Table Order
     *
     * @return HasOne
     */
    public function Order()
    {
        return $this->hasOne('App\Order', 'id', 'order_id');
    }

    /**
     * Relation to Table UjianAsesiJawaban
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function UjianAsesiJawaban()
    {
        return $this->hasMany('App\UjianAsesiJawaban', 'ujian_asesi_asesor_id', 'id');
    }

    /**
     * Relation to Table SoalPaket
     *
     * @return HasOne
     */
    public function SoalPaket()
    {
        return $this->hasOne('App\SoalPaket', 'id','soal_paket_id');
    }
}
