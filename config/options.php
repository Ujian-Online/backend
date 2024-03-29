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
    'user_assesi_gender' => [
        1 => 'Pria',
        0 => 'Wanita',
    ],
    'user_assesi_pendidikan_terakhir' => [
        'SD',
        'SMP',
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
    ],
    'asesi_custom_data_input_type' => [
        'text',
        'dropdown',
        'upload_image',
        'upload_pdf'
    ],
    'tuk_type' => [
        'sewaktu' => 'Sewaktu',
        'tukmandiri' => 'Tuk Mandiri',
        'jarakjauh' => 'Jarak Jauh',
    ],
    'tuk_bank_name' => [
        'Mandiri',
        'BCA',
        'BRI',
        'BNI',
        'BTN',
        'Permata',
    ],
    'sertifikasis_jenis_sertifikasi' => [
        'Baru',
        'Perpanjang'
    ],
    'soals_question_type' => [
        'essay',
        'multiple_option',
        'lisan',
        'wawancara'
    ],
    'soals_answer_option' => [
        'A',
        'B',
        'C',
        'D',
    ],
    'soal_pilihan_gandas_label' => [
        'A',
        'B',
        'C',
        'D',
    ],
    'ujian_asesi_asesors_status' => [
        'menunggu',
        'paket_soal_assigned',
        'penilaian',
        'selesai'
    ],
    'ujian_asesi_is_kompeten' => [
        0 => 'Tidak Kompeten',
        1 => 'Kompeten',
    ],
    'ujian_asesi_jawabans_question_type' => [
        'essay',
        'multiple_option',
        'lisan',
        'wawancara'
    ],
    'ujian_asesi_jawabans_answer_option' => [
        'A',
        'B',
        'C',
        'D',
    ],
    'ujian_asesi_jawaban_pilihans_label' => [
        'A',
        'B',
        'C',
        'D',
    ],
    'orders_tipe_sertifikasi' => [
        'baru',
        'perpanjang',
        'pkt',
        'rpl',
        'lainnya'
    ],
    'orders_tipe_sertifikasi_desc' => [
        'baru' => 'Sertifikasi',
        'perpanjang' => 'Sertifikasi Ulang',
        'pkt' => 'Pengakuan Kompetensi Terkini (PKT)',
        'rpl' => 'Rekognisi Pembelajaran Lampau',
        'lainnya' => 'Lainnya'
    ],
    // status menjadi complete kalau udah di assign asesor
    'orders_status' => [
        'waiting_payment',
        'pending_verification',
        'payment_rejected',
        'payment_verified',
        'canceled',
        'completed',
    ],
    'orders_status_tuk' => [
        'payment_rejected',
        'payment_verified',
        'canceled',
    ],
    'question_type' => [
        'essay',
        'multiple_option',
        'lisan',
        'wawancara'
    ],
    'question_type_berpengalaman' => [
        'lisan',
        'wawancara'
    ],
    'answer_option' => [
        'A',
        'B',
        'C',
        'D'
    ],
    'mapa_muks' => [
        'Ceklis Observasi Untuk Aktivitas Di Tempat Kerja Atau Tempat Kerja Simulasi',
        'Pertanyaan Untuk Mendukung Observasi',
        'Penjelasan Singkat Proyek Terkait Pekerjaan / Kegiatan Terstruktur Lainnya',
        'Tugas Praktik Demonstrasi',
        'Ceklis Evaluasi Portofolio',
        'Pertanyaan Wawancara',
        'Formulir Bukti Pihak Ketiga',
        'Pertanyaan Tertulis – Pilihan Ganda',
        'Pertanyaan Tertulis – Esai',
        'Pertanyaan Lisan',
        'Ceklis Meninjau Materi Uji Kompetensi',
    ],
    'jenis_ujian' => [
        'website',
        'wawancara'
    ]
];
