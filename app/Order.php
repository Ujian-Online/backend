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
        'asesi_id',
        'sertifikasi_id',
        'tuk_id',
        'tipe_sertifikasi',
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
     * Relation to Table User Asesi
     *
     * @return HasOne
     */
    public function Asesi()
    {
        return $this->hasOne('App\UserAsesi', 'id', 'asesi_id');
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
