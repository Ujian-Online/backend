<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailVerification extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * User Token
     *
     * @var string
     */
    public $token;

    /**
     * @var Int
     */
    public $asesiId;

    /**
     * Create a new message instance.
     *
     * @param String $token User Token
     * @param Int $asesiId
     */
    public function __construct($token, $asesiId)
    {
        $this->token    = $token;
        $this->asesiId  = $asesiId;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // get asesi detail
        $asesi = User::where('id', $this->asesiId)->firstOrFail();

        return $this->markdown('email/EmailVerification')
                ->with([
                    'url' => env('FRONTEND_URL') .
                            '/email/verification?token=' . $this->token,
                    'user' => $asesi,
                ]);
    }
}
