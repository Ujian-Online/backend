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
     * User Data
     *
     * @var object
     */
    public $user;

    /**
     * Order Data
     *
     * @var object
     */
    public $order;

    /**
     * Create a new message instance.
     *
     * @param int $userId User ID
     * @param int $orderId Order ID
     */
    public function __construct(int $userId, int $orderId)
    {
        // assign data to object
        $this->user = User::with('asesi')->findOrFail($userId);
        $this->order = Order::with([
            'sertifikasi', 'tuk', 'tuk.bank', 'user', 'user.asesi'
        ])->findOrFail($orderId);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('email/OrderConfirmation')
            ->with([
                'url' => env('FRONTEND_URL') .
                    '/member/order/' . $this->order->id
            ]);
    }
}
