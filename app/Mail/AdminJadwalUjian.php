<?php

namespace App\Mail;

use App\User;
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
    public $asesiId;

    /**
     * Create a new message instance.
     *
     * @param $asesiId
     */
    public function __construct($asesiId)
    {
        $this->asesiId = $asesiId;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // get asesi detail
        $asesi = User::with('asesi')->where('id', $this->asesiId)->firstOrFail();
        $asesiName = (!empty($asesi->asesi) and !empty($asesi->asesi->name)) ? $asesi->asesi->name : $asesi->email;

        return $this->markdown('email/AdminJadwalUjian')
            ->subject('Tentukan Jadwal Ujian dan Asesor untuk Asesi: ' . $asesiName)
            ->with([
                'asesi' => $asesi,
            ]);
    }
}
