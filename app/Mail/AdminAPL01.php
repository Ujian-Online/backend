<?php

namespace App\Mail;

use App\User;
use App\UserAsesiCustomData;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminAPL01 extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * User ID of User Admin
     *
     * @var Integer
     */
    public $adminId;

    /**
     * User ID of Asesi
     *
     * @var Integer
     */
    public $asesiId;

    /**
     * User Asesi Custom Data ID
     *
     * @var Integer
     */
    public $customDataId;

    /**
     * Create a new message instance.
     *
     * @param $adminId
     * @param $asesiId
     * @param $customDataId
     */
    public function __construct($adminId, $asesiId, $customDataId)
    {
        $this->adminId = $adminId;
        $this->asesiId = $asesiId;
        $this->customDataId = $customDataId;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // get admin
        $admin = User::where('id', $this->adminId)->where('type', 'admin')->firstOrFail();

        // get asesi detail
        $asesi = User::with('asesi')->where('id', $this->asesiId)->firstOrFail();

        // get asesi custom data
        $customData = null;
        if($this->customDataId) {
            $customData = UserAsesiCustomData::where('id', $this->customDataId)->firstOrFail();
        }

        $asesiName = (!empty($asesi->asesi) and !empty($asesi->asesi->name)) ? $asesi->asesi->name : $asesi->email;

        return $this->markdown('email/AdminAPL01')
            ->subject('Update Data Asesi Perlu di Verifikasi: ' . $asesiName)
            ->with([
                'admin' => $admin,
                'asesi' => $asesi,
                'customData' => $customData
            ]);
    }
}
