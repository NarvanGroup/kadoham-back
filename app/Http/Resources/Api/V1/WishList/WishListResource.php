<?php

namespace App\Http\Resources\Api\V1\WishList;

use App\Http\Resources\Api\V1\Item\ItemResource;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WishListResource extends JsonResource
{
    private Collection $items;

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'name'        => $this->name,
            'description' => $this->description,
            'share'       => $this->share,
            'items'       => ItemResource::collection($this->whenLoaded('items')),
            'visibility'  => $this->visibility,
            'items_count' => $this->itemsCount,
            'status'      => $this->status,
            'progress'    => $this->progress
        ];
    }
}
