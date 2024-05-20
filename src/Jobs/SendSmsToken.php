<?php

namespace Usermp\LaravelLogin\Jobs;

use Sentry\SentrySdk;
use Kavenegar\KavenegarApi;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendSmsToken implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $phoneNumber;
    protected $otp;

    /**
     * Create a new job instance.
     */
    public function __construct(string $phoneNumber, $otp)
    {
        $this->phoneNumber = $phoneNumber;
        $this->otp = $otp;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $apiKey = env("KAVENEGAR_API_KEY");
        $api = new KavenegarApi($apiKey);
        try {
            $api->Send(env('KAVEHNEGAR_SENDER'), $this->phoneNumber, $this->otp);
        } catch (\Exception $e) {
            SentrySdk::init();
            SentrySdk::getCurrentHub()->captureException($e);
        }
    }
}
