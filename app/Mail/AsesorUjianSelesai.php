<?php

namespace App\Mail;

use App\UjianAsesiAsesor;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AsesorUjianSelesai extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * @var Int
     */
    public $ujianId;

    /**
     * Ujian Asesi Asesor
     *
     * @var UjianAsesiAsesor
     */
    public $ujianasesiasesor;

    /**
     * Asesir Detail
     *
     * @var User
     */
    public $asesi;

    /**
     * Sertifikasi
     */
    public $sertifikasi;

    /**
     * Create a new message instance.
     *
     * @param $ujianId
     */
    public function __construct($ujianId)
    {
        $this->ujianId = $ujianId;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $ujianAsesiAsesor = UjianAsesiAsesor::with([
            'userasesi',
            'userasesi.asesi',
            'sertifikasi'
        ])->where('id', $this->ujianId)->firstOrFail();

        $this->ujianasesiasesor = $ujianAsesiAsesor;
        $this->asesi = $ujianAsesiAsesor->userasesi ?? null;
        $this->sertifikasi = $ujianAsesiAsesor->sertifikasi ?? null;

        $asesiName = (!empty($this->asesi->asesi) and !empty($this->asesi->asesi->name)) ? $this->asesi->asesi->name : $this->asesi->email;

        return $this->markdown('email/AsesorUjianSelesai')
            ->subject('[Ujian Selesai] Silahkan Beri Penilaian Ujian dari Asesi ' . $asesiName);
    }
}
