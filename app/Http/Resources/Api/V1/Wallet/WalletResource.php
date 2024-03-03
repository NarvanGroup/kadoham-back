<?php

namespace App\Http\Resources\Api\V1\Wallet;

use Illuminate\Http\Resources\Json\JsonResource;

class WalletResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'meta' => $this->meta,
            'balance' => $this->getBalance(),
            'deductible_balance' => $this->getDeductibleBalance()
        ];
    }

    public function getDeductibleBalance()
    {
        if (isset($this->meta['lend'])) {
            return $this->getBalance() - $this->meta['lend']['amount'];
        }

        return $this->getBalance();
    }

    public function getBalance(): int|float
    {
        if (str_starts_with($this->slug, 'IRG')) {
            return $this->balanceFloat;
        }

        return $this->balance;
    }
}
