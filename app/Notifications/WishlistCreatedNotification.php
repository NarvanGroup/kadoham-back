<?php

namespace App\Notifications;

use App\Models\Api\V1\WishList;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WishlistCreatedNotification extends Notification
{
    use Queueable;

    private WishList $wishlist;

    /**
     * Create a new notification instance.
     */
    public function __construct(WishList $wishlist)
    {
        $this->wishlist = $wishlist;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Your Wishlist Has Been Created!')
            ->greeting('Hello!')
            ->line('You have successfully created a new wishlist: ' . $this->wishlist->name)
            ->action('View Wishlist', url($this->wishlist->share))
            ->line('Thank you for using our application!')
            ->attach(public_path('img/logo.png'), [
                'as' => 'logo.jpg',
                'mime' => 'image/jpeg',
            ]);;
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
