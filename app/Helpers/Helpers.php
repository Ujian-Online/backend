<?php

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
        $apl02Elements = \App\AsesiSertifikasiUnitKompetensiElement::join('asesi_unit_kompetensi_dokumens', 'asesi_unit_kompetensi_dokumens.unit_kompetensi_id', '=', 'asesi_sertifikasi_unit_kompetensi_elements.unit_kompetensi_id')
            ->where('asesi_sertifikasi_unit_kompetensi_elements.asesi_id', $asesiId)
            ->where('asesi_unit_kompetensi_dokumens.asesi_id', $asesiId)
            ->where('asesi_unit_kompetensi_dokumens.sertifikasi_id', $sertifikasiId)
            ->get();

        // apl02 status
        $apl02StatusCount = [
            'isi_form' => null,
            'menunggu_verifikasi' => null,
            'form_ditolak' => null,
            'form_terverifikasi' => null,
        ];

        foreach($apl02Elements as $apl02Element) {
            // [Isi form] (Kalau belum isi sama sekali)
            if(empty($apl02Element->media_url)) {
                $apl02StatusCount['isi_form'][] = $apl02Element->id;
            }

            // Menunggu verifikasi [Update Form] (Kalau udah isi, tapi blum di verif semua)
            if(!empty($apl02Element->media_url) and !$apl02Element->is_verified) {
                $apl02StatusCount['menunggu_verifikasi'][] = $apl02Element->id;
            }

            // Form ditolak [Update Form] (Kalau udah isi, tapi ada yg ditolak)
            if(!empty($apl02Element->media_url) and !$apl02Element->is_verified and !empty($apl02Element->verification_note)) {
                $apl02StatusCount['form_ditolak'][] = $apl02Element->id;
            }

            // Form terverifikasi (Kalau udah verif semua)
            if(!empty($apl02Element->media_url) and $apl02Element->is_verified) {
                $apl02StatusCount['form_terverifikasi'][] = $apl02Element->id;
            }
        }

        // hitung total status
        $statusIsiForm = count($apl02StatusCount['isi_form'] ?? []);
        $statusMenungguVerifikasi = count($apl02StatusCount['menunggu_verifikasi'] ?? []);
        $statusFormDitolak = count($apl02StatusCount['form_ditolak'] ?? []);
        $statsFormTerverifikasi = count($apl02StatusCount['form_terverifikasi'] ?? []);

        // Bandingkan Total Status
        if($statusIsiForm > 0) {
            $apl02Status = 'isi_form';
        } else if($statusMenungguVerifikasi > 0) {
            $apl02Status = 'menunggu_verifikasi';
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
