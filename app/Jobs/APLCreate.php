<?php

namespace App\Jobs;

use App\AsesiSertifikasiUnitKompetensiElement;
use App\AsesiUnitKompetensiDokumen;
use App\SertifikasiUnitKompentensi;
use App\UserAsesi;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class APLCreate implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * User ID Asesi
     *
     * @var int
     */
    private $userId;

    /**
     * Sertifikasi ID
     *
     * @var int
     */
    private $sertifikasiId;

    /**
     * Create a new job instance.
     *
     * @param int $userId
     * @param int $sertifikasiId
     */
    public function __construct($userId, $sertifikasiId)
    {
        $this->userId = $userId;
        $this->sertifikasiId = $sertifikasiId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        /**
         * Create APL01
         */
        // check if APL01 is Ready or Not
        $apl01 = UserAsesi::where('user_id', $this->userId)->count();

        // only create once
        if($apl01 != 0) {
            UserAsesi::create(['user_id' => $this->userId]);
        }

        /**
         * Create APL02
         */

        // ambil detail unit kompetensi dan unit kompetensi element dari sertifikasi id
        $sertifikasiUK = SertifikasiUnitKompentensi::with('ukelement')
            ->where('sertifikasi_id', $this->sertifikasiId)->get();

        // buat variable array untuk simpan detail sertifikasi unit kompetensi element
        $asesiSertifikasiUK = [];
        // buat variable array untuk simpan detail sertifikasi unit kompetensi element
        $asesiSertifikasiUKElement = [];

        // loop sertifikasi unit kompetensi dan unit kompetensi element
        foreach($sertifikasiUK as $uk) {
            // update asesi unit kompetensi
            $asesiSertifikasiUK[] = [
                'asesi_id' => $this->userId,
                'unit_kompetensi_id' => $uk->id,
                'order' => $uk->order,
                'sertifikasi_id' => $uk->sertifikasi_id,
                'kode_unit_kompetensi' => $uk->kode_unit_kompetensi,
                'title' => $uk->title,
                'sub_title' => $uk->sub_title,
                'created_at' => now(),
                'updated_at' => now(),
            ];

            // check apakah ada element di dalam unit kompetensi atau tidak
            if(isset($uk->ukelement) and !empty($uk->ukelement)) {
                // kalau ada ukelement, maka looping datanya untuk di simpan ke asesi
                foreach($uk->ukelement as $ukelement) {
                    // update uk element ke asesi
                    $asesiSertifikasiUKElement[] = [
                        'asesi_id' => $this->userId,
                        'unit_kompetensi_id' => $ukelement->unit_kompetensi_id,
                        'desc' => $ukelement->desc,
                        'upload_instruction' => $ukelement->upload_instruction,
                        'is_verified' => false,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }
        }

        // simpan data apl02 unit kompetensi kalau belum ada di database
        $checkAsesiUK = AsesiUnitKompetensiDokumen::where('asesi_id', $this->userId)
            ->where('sertifikasi_id', $this->sertifikasiId)
            ->count();
        if($checkAsesiUK == 0) {
            AsesiUnitKompetensiDokumen::insert($asesiSertifikasiUK);
            AsesiSertifikasiUnitKompetensiElement::insert($asesiSertifikasiUKElement);
        }
    }
}
