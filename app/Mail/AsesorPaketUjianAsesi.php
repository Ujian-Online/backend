<?php

namespace App\Mail;

use App\UjianAsesiAsesor;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AsesorPaketUjianAsesi extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

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
     * @param $ujianAsesiAsesor
     */
    public function __construct($ujianAsesiAsesor)
    {
        $ujianAsesiAsesor = UjianAsesiAsesor::with([
            'userasesi',
            'userasesi.asesi',
            'sertifikasi'
        ])->findOrFail($ujianAsesiAsesor);

        $this->ujianasesiasesor = $ujianAsesiAsesor;
        $this->asesi = $ujianAsesiAsesor->userasesi ?? null;
        $this->sertifikasi = $ujianAsesiAsesor->sertifikasi ?? null;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $asesiName = (!empty($this->asesi->asesi) and !empty($this->asesi->asesi->name)) ? $this->asesi->asesi->name : $this->asesi->email;

        return $this->markdown('email/AsesorPaketUjianAsesi')
                ->subject('Anda mendapatkan tugas penilaian untuk Asesi Baru: ' . $asesiName);
    }
}
