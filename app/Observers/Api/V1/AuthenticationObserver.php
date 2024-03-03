<?php

namespace App\Observers\Api\V1;

use App\Channels\DiscordWebhookChannel;
use App\Enums\DiscordChannelsEnum;
use App\Models\Api\V1\Authentication;

class AuthenticationObserver
{
    /**
     * Handle the Authentication "created" event.
     */
    public function created(Authentication $authentication): void
    {
        (new DiscordWebhookChannel())
            ->setContent("@everyone")
            ->setUsername('Zarinext - Postman')
            ->setTts(false)
            ->setTitle("درخواست احراز هویت جدید داریم!")
            ->setColor(hexdec("00FF00"))
            ->setTimestamp(date("c"))
            ->setFields(
                [
                    [
                        'name' => 'نام و نام خانوادگی',
                        'value' => $authentication->user->fullName ?? null,
                        'inline' => false
                    ],
                    [
                        'name' => 'نام پدر',
                        'value' => $authentication->user->father_name ?? null,
                        'inline' => false
                    ],
                    [
                        'name' => 'کد ملی',
                        'value' => $authentication->user->nid ?? null,
                        'inline' => false
                    ],
                    [
                        'name' => 'تاریخ تولد',
                        'value' => $authentication->user->dob ?? null,
                        'inline' => false
                    ],
                    [
                        'name' => 'شماره تماس',
                        'value' => $authentication->user->mobile ?? null,
                        'inline' => false
                    ]

                ]
            )
            ->setImageUrl($authentication->user->image)
            ->setReceiver(DiscordChannelsEnum::NEW_AUTHENTICATION)
            ->send();
    }

    /**
     * Handle the Authentication "updated" event.
     */
    public function updated(Authentication $authentication): void
    {
        //
    }

    /**
     * Handle the Authentication "deleted" event.
     */
    public function deleted(Authentication $authentication): void
    {
        //
    }

    /**
     * Handle the Authentication "restored" event.
     */
    public function restored(Authentication $authentication): void
    {
        //
    }

    /**
     * Handle the Authentication "force deleted" event.
     */
    public function forceDeleted(Authentication $authentication): void
    {
        //
    }
}
