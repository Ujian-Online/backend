<?php

namespace App\Mail;

use App\Order;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderConfirmation extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * @var Int
     */
    public $userId;

    /**
     * @var Int
     */
    public $orderId;

    /**
     * Create a new message instance.
     *
     * @param int $userId User ID
     * @param int $orderId Order ID
     */
    public function __construct(int $userId, int $orderId)
    {
        $this->userId = $userId;
        $this->orderId = $orderId;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // assign data to object
        $user = User::with('asesi')->where('id', $this->userId)->firstOrFail();
        $order = Order::with([
            'sertifikasi', 'tuk', 'tuk.bank', 'user', 'user.asesi'
        ])->where('id', $this->orderId)->firstOrFail();

        return $this->markdown('email/OrderConfirmation')
            ->with([
                'url' => env('FRONTEND_URL') .
                    '/member/order/' . $order->id,
                'user' => $user,
                'order' => $order,
            ]);
    }
}
