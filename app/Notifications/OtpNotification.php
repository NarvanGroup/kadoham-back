<?php

namespace App\Notifications;

use App\Channels\KavenegarOtpSmsChannel;
use App\Channels\SmsIrOtpSmsChannel;
use App\Channels\SmsIrSmsChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class OtpNotification extends Notification
{
    use Queueable;

    private string $token;

    /**
     * Create a new notification instance.
     */
    public function __construct(string $token)
    {
        $this->token = $token;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return [SmsIrOtpSmsChannel::class];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toSms(object $notifiable): array
    {
        return [
            'template' => '100000',
            'token'    => $this->token
        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [//
        ];
    }
}
