<?php

namespace App\Jobs;

use App\Mail\AdminJadwalUjian;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class JadwalUjianAdminNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * User ID of Asesi
     *
     * @var Integer
     */
    private $asesiId;

    /**
     * Create a new job instance.
     *
     * @param $asesiId
     */
    public function __construct($asesiId)
    {
        $this->asesiId = $asesiId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // get asesi detail
        $userAsesi = User::with('asesi')->where('id', $this->asesiId)->firstOrFail();

        // get user with admin access
        $userAdmins = User::where('type', 'admin')->get();

        // loop all admin detail, and send them email
        foreach ($userAdmins as $userAdmin) {
            Mail::to($userAdmin->email)->send(new AdminJadwalUjian($userAsesi));
        }
    }
}
