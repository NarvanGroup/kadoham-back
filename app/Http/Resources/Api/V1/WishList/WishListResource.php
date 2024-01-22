<?php

namespace App\Http\Resources\Api\V1\WishList;

use App\Http\Resources\Api\V1\Item\ItemResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WishListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'user_id' => $this->user_id,
            'items' => ItemResource::collection($this->whenLoaded('items')),
        ];
    }
}
