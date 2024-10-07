<?php

namespace App\Jobs;

use App\Models\Api\V1\Card;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Modules\Inquiry\App\Services\Bank\BankService;


class GetCardBankJob implements ShouldQueue
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
        $this->card->update([
            'bank_name' => BankService::findBankNameByCard($this->card->card_number),
        ]);
    }
}
