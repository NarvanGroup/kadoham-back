<?php

namespace App\Http\Resources\Api\V1\Wallet;

use Illuminate\Http\Resources\Json\JsonResource;

class WalletResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'                 => $this->uuid,
            'name'               => $this->name,
            'slug'               => $this->slug,
            'description'        => $this->description,
            'meta'               => $this->meta,
            'balance'            => $this->balance,
            'transactions'       => TransactionResource::collection($this->transactions)
        ];
    }
}
