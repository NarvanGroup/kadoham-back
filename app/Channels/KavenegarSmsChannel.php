<?php

namespace App\Channels;

use Exception;
use Http;
use Illuminate\Notifications\Notification;
use Log;

class KavenegarSmsChannel
{
    private string $apiKey;

    private string $sender;

    public function __construct()
    {
        $this->apiKey = config('services.kavenegar.key');
        $this->sender = config('services.kavenegar.sender');
    }

    public function send(object $notifiable, Notification $notification): void
    {
        $message = $notification->toSMS($notifiable);

        $phoneNumber = '09306057083';

        try {
            Http::asJson()->acceptJson()->post("https://api.kavenegar.com/v1/{$this->apiKey}/sms/send.json?receptor={$phoneNumber}&sender={$this->sender}&message={$message}");
        } catch (Exception $e) {
            Log::error('Kavenegar SMS Error: '.$e->getMessage());
        }
    }
}
