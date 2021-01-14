<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailVerification extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * User Token
     *
     * @var string
     */
    public $token;

    /**
     * User Data
     *
     * @var object
     */
    public $user;

    /**
     * Create a new message instance.
     *
     * @param String $token User Token
     * @param Object $user User Data
     *
     * @return void
     */
    public function __construct($token, User $user)
    {
        $this->token    = $token;
        $this->user     = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // generate expired url
        $expired = now()->addDay()->timestamp;

        return $this->markdown('email/EmailVerification')
                ->with([
                    'url' => env('FRONTEND_URL') .
                            '/email/verification?token=' . $this->token
                ]);
    }
}
