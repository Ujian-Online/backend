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
use Exception;
use Illuminate\Support\Facades\Log;

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
        if($apl01 == 0) {
            UserAsesi::create(['user_id' => $this->userId]);
        }

        /**
         * Create APL02
         */

        // ambil detail unit kompetensi dan unit kompetensi element dari sertifikasi id
        $sertifikasiUK = SertifikasiUnitKompentensi::with([
                'unitkompetensi',
                'unitkompetensi.ukelement'
            ])
            ->where('sertifikasi_id', $this->sertifikasiId)
            ->get();

        // buat variable array untuk simpan detail sertifikasi unit kompetensi element
        $asesiSertifikasiUK = [];
        // buat variable array untuk simpan detail sertifikasi unit kompetensi element
        $asesiSertifikasiUKElement = [];

        // loop sertifikasi unit kompetensi dan unit kompetensi element
        foreach($sertifikasiUK as $key => $sertifikasi) {
            // update asesi unit kompetensi
            $asesiSertifikasiUK[] = [
                'asesi_id' => $this->userId,
                'unit_kompetensi_id' => $sertifikasi->unit_kompetensi_id,
                'order' => $sertifikasi->order,
                'sertifikasi_id' => $sertifikasi->sertifikasi_id,
                'kode_unit_kompetensi' => $sertifikasi->unitkompetensi->kode_unit_kompetensi,
                'title' => $sertifikasi->unitkompetensi->title,
                'sub_title' => $sertifikasi->unitkompetensi->sub_title,
                'created_at' => now(),
                'updated_at' => now(),
            ];

            // check apakah ada element di dalam unit kompetensi atau tidak
            if(isset($sertifikasi->unitkompetensi->ukelement) and !empty($sertifikasi->unitkompetensi->ukelement)) {
                // kalau ada ukelement, maka looping datanya untuk di simpan ke asesi
                foreach($sertifikasi->unitkompetensi->ukelement as $ukelement) {
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

    /**
     * The job failed to process.
     *
     * @param Exception $exception
     * @return void
     */
    public function failed(Exception $exception)
    {
        Log::info($exception);
    }
}
