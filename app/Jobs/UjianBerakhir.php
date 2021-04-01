<?php

namespace App\Jobs;

use App\UjianAsesiAsesor;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Exception;

class UjianBerakhir implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // ambil ujian dengan status paket_soal_assigned dan ujian_start tidak kosong datanya
        $ujians = UjianAsesiAsesor::with(['ujianjadwal', 'soalpaket'])
            ->where('status', 'paket_soal_assigned')
            ->whereNotNull('ujian_start')
            ->get();

        // loop ujian
        foreach($ujians as $ujian)
        {
            // ambil waktu sekarang
            $now = Carbon::now();

            // get time duration and parse
            $durasiUjian = Carbon::parse($ujian->soalpaket->durasi_ujian);
            // format to minutes
            $durasiUjianMenit = ($durasiUjian->hour * 60) + $durasiUjian->minute;
            // ujian jam di mulai + add minutes durasi ujian
            $ujianJamDimulai = Carbon::parse($ujian->ujian_start)->addMinutes($durasiUjianMenit)->timestamp;
            // time now, timestamp
            $dateNowTimestamp = $now->timestamp;

            // Kalau waktu sekarang lebih besar atau sama dengan ujian jam dimulai + durasi ujian
            // maka Waktu Ujian Telah Berakhir.!
            if($dateNowTimestamp >= $ujianJamDimulai) {
                // update status ujian yg sudah berakhir ke penilaian
                UjianAsesiAsesor::where('id', $ujian->id)
                    ->update(['status' => 'penilaian']);
            }
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
