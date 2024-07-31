<?php

namespace App\Http\Resources\Api\V1\Wallet;

use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'         => $this->uuid,
            'payer_id'   => $this->payable_id,
            'type'       => $this->type,
            'amount'     => $this->amount,
            'confirmed'  => $this->confirmed,
            'meta'       => $this->meta,
            'created_at' => $this->created_at,
        ];
    }
}
