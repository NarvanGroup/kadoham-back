<?php

namespace App\Http\Resources\Api\V1\Item;

use App\Http\Resources\Api\V1\User\UserSharedWishlistResource;
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
            'id'                => $this->id,
            'is_self_completed' => $this->user_id === $this->item->user_id,
            'buyer'             => $this->is_public ? UserSharedWishlistResource::make($this->user) : 'private',
            'buyers'            => $this->buyers,
            'is_public'         => $this->is_public,
            'content'           => $this->content,
            'quantity'          => $this->quantity,
            'amount'            => $this->amount,
            'created_at'        => $this->created_at,
            'updated_at'        => $this->updated_at,
            'item'              => ItemResource::make($this->whenLoaded('item'))
        ];
    }
}
