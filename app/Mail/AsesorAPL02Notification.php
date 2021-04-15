<?php

namespace App\Mail;

use App\Sertifikasi;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AsesorAPL02Notification extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $asesiId;
    public $sertifikasiId;
    public $asesorId;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($asesiId, $sertifikasiId, $asesorId)
    {
        $this->asesiId = $asesiId;
        $this->sertifikasiId = $sertifikasiId;
        $this->asesorId = $asesorId;
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

        // sertifikasi detail
        $sertifikasi = Sertifikasi::where('id', $this->sertifikasiId)->firstOrFail();

        return $this->markdown('email/AsesorAPL02Notification')
            ->subject('Asesi ['.$asesiName.'] telah melakukan update data APL02 untuk Sertifikasi ['.$sertifikasi->title.']')
            ->with([
                'asesi' => $asesi,
                'sertifikasi' => $sertifikasi,
            ]);
    }
}
