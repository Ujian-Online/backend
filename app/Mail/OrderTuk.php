<?php

namespace App\Mail;

use App\Order;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderTuk extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * User ID of Asesi
     *
     * @var Integer
     */
    protected $asesiId;

    /**
     * Order ID
     *
     * @var Integer
     */
    protected $orderId;

    /**
     * Create a new message instance.
     *
     * @param $asesiId
     * @param $orderId
     */
    public function __construct($asesiId, $orderId)
    {
        $this->asesiId  = $asesiId;
        $this->orderId  = $orderId;
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

        // order detail
        $order = Order::with('sertifikasi')->where('id', $this->orderId)->firstOrFail();

        // get asesi detail
        $asesiName = (!empty($asesi->asesi) and !empty($asesi->asesi->name)) ? $asesi->asesi->name : $asesi->email;

        return $this->markdown('email/OrderTuk')
                ->subject('[Order ID: '. $order->id .'] Verifikasi Data Pembayaran Dari Asesi: ' . $asesiName)
                ->with([
                    'asesi' => $asesi,
                    'order' => $order,
                ]);
    }
}
