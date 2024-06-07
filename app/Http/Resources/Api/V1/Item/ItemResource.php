<?php

namespace App\Http\Resources\Api\V1\Item;

use App\Helper\UploadHelper;
use App\Http\Resources\Api\V1\WishList\WishListResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'             => $this->id,
            'name'           => $this->name,
            'price'          => $this->price,
            'quantity'       => $this->quantity,
            'link'           => $this->link,
            'image'          => UploadHelper::url($this->image),
            'rate'           => $this->rate,
            'where_to_buy'   => $this->where_to_buy,
            'description'    => $this->description,
            'visibility'     => $this->visibility,
            'status'         => $this->status,
            'wish_lists'     => WishListResource::make($this->whenLoaded('wishList')),
            'completer_info' => ItemBuyersResource::make($this->whenLoaded('buyer')),
        ];
    }
}
