<?php

/**
 * File ini digunakan untuk menyimpan options atau pilihan di database
 * dan dapat di gunakan kembali pada form dengan menu dropdown atau lainnya
 *
 * Data yang dimasukkan berbentuk array
 */

return [
    'user_type' => [
        'admin',
        'tuk',
        'assesor',
        'asessi'
    ],
    'user_status' => [
        'active',
        'inactive',
        'suspend'
    ],
    // true or false
    'user_assesi_gender' => [
        0 => 'Wanita',
        1 => 'Pria',
    ],
    'user_assesi_pendidikan_terakhir' => [
        'SMA',
        'SMK',
        'D1',
        'D2',
        'D3',
        'D4',
        'S1',
        'S2',
        'S3',
    ],
    'user_assesi_has_job' => [
        0 => 'Tidak Bekerja',
        1 => 'Bekerja',
    ]
];
