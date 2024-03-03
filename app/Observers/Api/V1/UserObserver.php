<?php

namespace App\Observers\Api\V1;

use App\Models\Api\V1\User;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        /*        (new DiscordWebhookChannel())
                    ->setContent("@everyone")
                    ->setUsername('Zarinext - Postman')
                    ->setTts(false)
                    ->setTitle("کاربر جدید داریم!")
                    ->setColor(hexdec("00FF00"))
                    ->setTimestamp(date("c"))
                    ->setFields(
                        [
                            [
                                'name' => 'شماره تماس',
                                'value' => $user->mobile ?? null,
                                'inline' => false
                            ]
                        ]
                    )
                    ->setReceiver(DiscordChannelsEnum::NEW_USER)
                    ->send();*/

/*        $walletData = Product::select(['title', 'slug'])->get()->map(static fn($item) => [
            'name' => $item->slug,
            'slug' => $item->title,
            'meta' => json_encode(['unit' => str_starts_with($item->slug, 'IRG') ? 'gram' : 'piece'])
        ])->toArray();
        $user->wallets()->createMany($walletData);*/
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        //
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        //
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        //
    }
}
