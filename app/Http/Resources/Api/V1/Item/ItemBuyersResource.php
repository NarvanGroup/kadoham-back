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
            'is_self_completed' => auth()->user()->id === $this->user_id,
            'buyers'            => $this->buyers,
            'is_public'         => $this->is_public,
            'content'           => $this->content
        ];
    }
}
