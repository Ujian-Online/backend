<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderTuk extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * User Detail with Asesi
     * @var Object
     */
    public $asesi;

    /**
     * Order Object
     *
     * @var Object
     */
    public $order;

    /**
     * Create a new message instance.
     *
     * @param $asesi
     * @param $order
     */
    public function __construct($asesi, $order)
    {
        $this->asesi = $asesi;
        $this->order = $order;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $asesiName = (!empty($this->asesi->asesi) and !empty($this->asesi->asesi->name)) ? $this->asesi->asesi->name : $this->asesi->email;

        return $this->markdown('email/OrderTuk')
                ->subject('[Order ID: '. $this->order->id .'] Verifikasi Data Pembayaran Dari Asesi: ' . $asesiName);
    }
}
