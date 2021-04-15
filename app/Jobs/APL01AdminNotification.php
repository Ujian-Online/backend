<?php

namespace App\Jobs;

use App\Mail\AdminAPL01;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Exception;

class APL01AdminNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * User ID of Asesi
     *
     * @var Integer
     */
    protected $asesiId;

    /**
     * User Asesi Custom Data ID
     *
     * @var Integer
     */
    protected $customDataId;

    /**
     * Create a new job instance.
     *
     * @param $asesiId
     * @param $customDataId
     */
    public function __construct($asesiId, $customDataId = null)
    {
        $this->asesiId = $asesiId;
        $this->customDataId = $customDataId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // get user with admin access
        $userAdmins = User::where('type', 'admin')->get();

        // loop all admin detail, and send them email
        foreach ($userAdmins as $userAdmin) {
            Mail::to($userAdmin->email)->send(new AdminAPL01($userAdmin->id, $this->asesiId, $this->customDataId));
        }
    }

    /**
     * The job failed to process.
     *
     * @param Exception $exception
     * @return void
     */
    public function failed(Exception $exception)
    {
        Log::info($exception);
    }
}
