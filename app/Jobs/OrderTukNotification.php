<?php

namespace App\Jobs;

use App\Mail\OrderTuk;
use App\Order;
use App\User;
use App\UserTuk;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class OrderTukNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * User ID of Asesi
     *
     * @var Integer
     */
    private $asesiId;

    /**
     * Order ID
     *
     * @var Integer
     */
    private $orderId;

    /**
     * TUK ID
     *
     * @var Integer
     */
    private $tukId;



    /**
     * Create a new job instance.
     *
     * @param $asesiId
     * @param $orderId
     * @param $tukId
     */
    public function __construct($asesiId, $orderId, $tukId)
    {
        $this->asesiId = $asesiId;
        $this->orderId = $orderId;
        $this->tukId = $tukId;
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

        // order detail
        $order = Order::with('sertifikasi')->where('id', $this->orderId)->firstOrFail();

        // get user tuk
        $userTuk = UserTuk::with('user')->where('tuk_id', $this->tukId)->get();

        foreach($userTuk as $tuk) {
            Mail::to($tuk->user->email)->send(new OrderTuk($userAsesi, $order));
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
