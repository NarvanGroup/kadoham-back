<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Modules\Sms\App\Traits\MessageFormaterTrait;

class WelcomeNotification extends Notification
{
    use Queueable, MessageFormaterTrait;

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the SMS representation of the notification.
     */
    public function toSms(object $notifiable): string
    {
        return $this->line("عزیزدل من چطوره؟")->line("نشناختی؟")->line("سرورتم ;)")->line("دارم خطوط خدماتیمونو تست میکنم عزیزم ❤️")->cancel();
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)->line('The introduction to the notification.')->action('Notification Action',
            url('/'))->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'message'    => 'شما با موفقیت وارد سایت شدید!',
            'created_at' => now()
        ];
    }
}
