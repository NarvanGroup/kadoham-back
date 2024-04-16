<?php

namespace App\Http\Resources\Api\V1\Item;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ItemBuyersResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'buyers'    => $this->buyers,
            'is_public' => $this->price,
            'content'   => $this->quantity
        ];
    }
}
