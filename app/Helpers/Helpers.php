<?php

use Illuminate\Support\Facades\Redis;

if (!function_exists('gravatar')) {
    /**
     * Generate Gravatar URL
     *
     * @param {string} email
     */
    function gravatar($email)
    {
        return "https://www.gravatar.com/avatar/" . md5(strtolower(trim($email)));
    }
}

if (!function_exists('upload_to_s3')) {
    /**
     * Upload File to AWS S3 and Return URL S3
     *
     * @param {string} file
     */
    function upload_to_s3($file)
    {
        // generate uuid filename
        $fileextension = $file->extension();
        $filenewName   = (string) \Str::uuid() . '.' . $fileextension;

        // folder path based on year/month
        $dateNow  = now();
        $filePath = '/' . $dateNow->year . '/' . $dateNow->month;

        // store file attachment to s3 with public access
        $filesave = \Storage::disk('s3')->putFileAs(
            $filePath,
            $file,
            $filenewName,
            'public'
        );

        // build url to files
        $urlFile = \Storage::disk('s3')->url($filesave);

        return $urlFile;
    }
}

// apl02 status helper
if(!function_exists('apl02_status')) {
    /**
     * Kalkulasi APL02 Status Berdasarkan Element
     *
     * @param $asesiId int
     * @param $sertifikasiId int
     * @return string isi_form|menunggu_verifikasi|form_ditolak|form_terverifikasi|null
     */
    function apl02_status($asesiId, $sertifikasiId) {
        // variable return status
        $apl02Status = null;

        // Ambil data dari database
        $apl02Elements = \App\AsesiUnitKompetensiDokumen::with([
            'asesisertifikasiunitkompetensielement' => function ($query) use ($asesiId) {
                $query->where('asesi_id', $asesiId);
            },
            'asesisertifikasiunitkompetensielement.media' => function ($query) use ($asesiId) {
                $query->where('asesi_id', $asesiId);
            }
        ])
        ->where('asesi_id', $asesiId)
        ->where('sertifikasi_id', $sertifikasiId)
        ->firstOrFail();

        // apl02 status
        $apl02StatusCount = [
            'isi_form' => null,
            'menunggu_verifikasi' => null,
            'form_ditolak' => null,
            'form_terverifikasi' => null,
        ];

        foreach($apl02Elements->asesisertifikasiunitkompetensielement as $apl02Element) {
            // [Isi form] (Kalau belum isi sama sekali)
            if(count($apl02Element->media) == 0) {
                $apl02StatusCount['isi_form'][] = $apl02Element->id;
            }

            // Menunggu verifikasi [Update Form] (Kalau udah isi, tapi blum di verif semua)
            if(count($apl02Element->media) > 0 and $apl02Element->is_verified == 0) {
                $apl02StatusCount['menunggu_verifikasi'][] = $apl02Element->id;
            }

            // Form ditolak [Update Form] (Kalau udah isi, tapi ada yg ditolak)
            if(count($apl02Element->media) > 0 and $apl02Element->is_verified == 0 and !empty($apl02Element->verification_note)) {
                $apl02StatusCount['form_ditolak'][] = $apl02Element->id;
            }

            // Form terverifikasi (Kalau udah verif semua)
            if(count($apl02Element->media) > 0 and $apl02Element->is_verified == 1) {
                $apl02StatusCount['form_terverifikasi'][] = $apl02Element->id;
            }
        }

        // hitung total status
        $statusIsiForm = count($apl02StatusCount['isi_form'] ?? []);
        $statusMenungguVerifikasi = count($apl02StatusCount['menunggu_verifikasi'] ?? []);
        $statusFormDitolak = count($apl02StatusCount['form_ditolak'] ?? []);
        $statsFormTerverifikasi = count($apl02StatusCount['form_terverifikasi'] ?? []);

        // Bandingkan Total Status
        if($statusMenungguVerifikasi > 0) {
            $apl02Status = 'menunggu_verifikasi';
        } else if($statusIsiForm > 0) {
            $apl02Status = 'isi_form';
        } else if($statusFormDitolak > 0) {
            $apl02Status = 'form_ditolak';
        } else if($statsFormTerverifikasi) {
            $apl02Status = 'form_terverifikasi';
        } else {
            $apl02Status = '';
        }

        // return status ke string
        return $apl02Status;
    }
}

if(!function_exists('soal_validate')) {
    /**
     * Soal Validation Based on Soal ID, Unit Kompetensi ID or Sertifikasi ID
     *
     * @param $soal_id
     * @param null $unit_kompetensi_id
     * @param null $sertifikasi_id
     * @return mixed
     */
    function soal_validate($soal_id, $unit_kompetensi_id = null, $sertifikasi_id = null)
    {
        try {
            return \App\Soal::select(['soals.*'])
                ->join('sertifikasi_unit_kompentensis', 'sertifikasi_unit_kompentensis.unit_kompetensi_id', '=', 'soals.unit_kompetensi_id')
                ->leftJoin('sertifikasis', 'sertifikasis.id', '=', 'sertifikasi_unit_kompentensis.sertifikasi_id')
                ->where('soals.id', $soal_id)
                ->when($unit_kompetensi_id, function($query) use ($unit_kompetensi_id) {
                    $query->where('soals.unit_kompetensi_id', $unit_kompetensi_id);
                })
                ->when($sertifikasi_id, function($query) use ($sertifikasi_id) {
                    $query->where('sertifikasis.id', $sertifikasi_id);
                })
                ->firstOrFail();
        } catch (\Exception $e) {
            return false;
        }
    }
}

if(!function_exists('durasi_ujian')) {
    function durasi_ujian($value)
    {
        $date = \Carbon\Carbon::now();
        $dateNow = $date->toDateString();
        $dateTime = $dateNow . ' ' . $value;
        $intMinutes = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $dateTime)
            ->diffInMinutes($date->startOfDay());

        return $intMinutes;
    }
}

if(!function_exists("redis_check")) {
    /**
     * Check apakah redis key ditemukan atau tidak
     *
     * @param $key string
     * @return bool true = send email, false = don't send email
     */
    function redis_check($key) {
        // check redis data by redis key
        $getStatus = Redis::get($key);

        // if redis data not found, then set redis
        // and sending email to asesor
        if(!$getStatus) {
            Redis::set($key, "ok", 'EX', (5 * 60));

            // if true, can send email
            return true;
        } else {
            // if false, don't send email
            return false;
        }
    }
}

if(!function_exists('re_captcha_validate')) {
    function re_captcha_validate($key, $response) {
        try {
            $data = [
                'secret' => $key,
                'response' => $response
            ];

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify");
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            // running curl
            $result = curl_exec($ch);

            // throw error
            if (curl_errno($ch)) {
                throw new Exception(curl_error($ch));
            }

            // stop connection
            curl_close($ch);

            // return result request
            $response = json_decode($result);

            if($response->success) {
                return true;
            } else {
                return false;
            }
        } catch (\Exception $e) {
            return false;
        }
    }
}
