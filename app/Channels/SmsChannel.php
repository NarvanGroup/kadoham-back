<?php

namespace App\Channels;

use Illuminate\Support\Facades\Http;

class SmsChannel
{
    private ?string $receiver = null;
    private ?string $otp = null;


    /**
     * @param string|null $receiver
     * @return SmsChannel
     */
    public function setReceiver(?string $receiver): self
    {
        $this->receiver = $receiver;
        return $this;
    }

    /**
     * @param string|null $otp
     * @return SmsChannel
     */
    public function setOtp(?string $otp): self
    {
        $this->otp = $otp;
        return $this;
    }

    public function send(): void
    {
        $data = [
            "mobile" => $this->receiver,
            "templateId" => 355933,
            "parameters" => [
                [
                    "name" => "otp",
                    "value" => $this->otp
                ]
            ]
        ];

        $test = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Accept' => 'text/plain',
            'x-api-key' => env('SMS_API_KEY')
        ])->post('https://api.sms.ir/v1/send/verify', $data);
    }
}
