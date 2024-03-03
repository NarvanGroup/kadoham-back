<?php

namespace App\Http\Resources\Api\V1\Card;

use Illuminate\Http\Resources\Json\JsonResource;

class CardResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'bank_name' => $this->bank_name,
            'card_number' => $this->card_number,
            'iban' => $this->iban,
        ];
    }
}
