<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
}
