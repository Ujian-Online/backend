<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminJadwalUjian extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * User Detail with Asesi
     * @var Object
     */
    public $asesi;

    /**
     * Create a new message instance.
     *
     * @param $asesi
     */
    public function __construct($asesi)
    {
        $this->asesi = $asesi;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $asesiName = (!empty($this->asesi->asesi) and !empty($this->asesi->asesi->name)) ? $this->asesi->asesi->name : $this->asesi->email;

        return $this->markdown('email/AdminJadwalUjian')
            ->subject('Tentukan Jadwal Ujian dan Asesor untuk Asesi: ' . $asesiName);
    }
}
