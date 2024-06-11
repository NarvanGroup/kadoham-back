<?php

namespace App\Http\Resources\Api\V1\User;

use App\Helper\UploadHelper;
use App\Http\Resources\Api\V1\Address\AddressResource;
use App\Http\Resources\Api\V1\Interest\InterestResource;
use App\Http\Resources\Api\V1\Item\ItemResource;
use App\Http\Resources\Api\V1\SocialMedia\SocialMediaResource;
use App\Http\Resources\Api\V1\WishList\WishListResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserSharedWishlistResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'first_name'   => $this->first_name,
            'last_name'    => $this->last_name,
            'username'     => $this->username,
            'gender'       => $this->gender,
            'dob'          => $this->dob,
            'image'        => UploadHelper::url($this->image),
            'addresses'    => AddressResource::collection($this->whenLoaded('addresses')),
            'interests'    => InterestResource::make($this->whenLoaded('interests')),
            'social_media' => SocialMediaResource::collection($this->whenLoaded('socialMedia')),
            'wish_lists'   => WishListResource::collection($this->whenLoaded('wishLists')),
            'items'        => ItemResource::collection($this->whenLoaded('items')),
        ];
    }
}
