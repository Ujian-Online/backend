<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminAPL01 extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Admin Detail
     *
     * @var Object
     */
    public $admin;

    /**
     * User Detail with Asesi
     * @var Object
     */
    public $asesi;

    /**
     * Custom Data Detail
     *
     * @var Object
     */
    public $customData;

    /**
     * Create a new message instance.
     *
     * @param $admin
     * @param $asesi
     * @param $customData
     */
    public function __construct($admin, $asesi, $customData)
    {
        $this->admin = $admin;
        $this->asesi = $asesi;
        $this->customData = $customData;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $asesiName = (!empty($this->asesi->asesi) and !empty($this->asesi->asesi->name)) ? $this->asesi->asesi->name : $this->asesi->email;

        return $this->markdown('email/AdminAPL01')
            ->subject('Update Data Asesi Perlu di Verifikasi: ' . $asesiName);
    }
}
