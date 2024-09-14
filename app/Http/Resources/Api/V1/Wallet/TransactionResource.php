<?php

namespace App\Http\Resources\Api\V1\Wallet;

use App\Http\Resources\Api\V1\User\UserSharedWishlistResource;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    public function toArray($request)
    {
        dd($this);
        return [
            'id'         => $this->uuid,
            'payer_id'   => $this->payable_id,
            'payer'      => UserSharedWishlistResource::make($this->user),
            'type'       => $this->type,
            'amount'     => $this->amount,
            'confirmed'  => $this->confirmed,
            'meta'       => $this->meta,
            'created_at' => $this->created_at,
        ];
    }
}
