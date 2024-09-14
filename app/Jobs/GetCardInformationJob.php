<?php

namespace App\Jobs;

use App\Models\Api\V1\Card;
use App\Services\Api\V1\BankService;
use DB;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class GetCardInformationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private Card $card;

    /**
     * Create a new job instance.
     */
    public function __construct(Card $card)
    {
        $this->card = $card;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {

        // Create a new card instance and set properties
        $card = Card::updateOrCreate([
            'user_id'     => $this->card->user_id,
            'card_number' => $this->card->card_number,
        ]);

        // Use a transaction to ensure atomicity
        DB::transaction(static function () use ($card) {
            $accountInfo = BankService::getShebaJibit($card->card_number);

            // Set additional properties from account info
            $card->update([
                'iban'           => $accountInfo['iban'],
                'owner'          => $accountInfo['owners'][0],
                'account_number' => $accountInfo['accountNumber'],
            ]);
        });
    }
}
