<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'asesi_id', // id dari table user dengan relasi ke table userasesi
        'sertifikasi_id',
        'tuk_id',
        'tipe_sertifikasi', // see config('options.orders_tipe_sertifikasi')
        'sertifikat_number_old',
        'sertifikat_number_new',
        'sertifikat_date_old',
        'sertifikat_date_new',
        'sertifikat_media_url_old',
        'sertifikat_media_url_new',
        'kode_sertifikat',
        'original_price',
        'tuk_price',
        'tuk_price_training',
        'status',
        'comment_rejected',
        'comment_verification',
        'transfer_from_bank_name',
        'transfer_from_bank_account',
        'transfer_from_bank_number',
        'transfer_to_bank_name',
        'transfer_to_bank_account',
        'transfer_to_bank_number',
        'transfer_date',
        'media_url_bukti_transfer',
        'expired_date',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'original_price',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'sertifikat_date_old' => 'date:Y-m-d',
        'sertifikat_date_new' => 'date:Y-m-d',
        'transfer_date' => 'date:Y-m-d',
        'expired_date' => 'date:Y-m-d',
    ];

    /**
     * Relation to Table User
     *
     * @return HasOne
     */
    public function User()
    {
        return $this->hasOne('App\User', 'id', 'asesi_id');
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
     * Relation to Table TUK
     *
     * @return HasOne
     */
    public function Tuk()
    {
        return $this->hasOne('App\Tuk', 'id', 'tuk_id');
    }
}
