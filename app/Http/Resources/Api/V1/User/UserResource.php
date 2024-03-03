<?php

namespace App\Http\Resources\Api\V1\User;

use App\Http\Resources\Api\V1\Address\AddressResource;
use App\Http\Resources\Api\V1\Card\CardResource;
use App\Http\Resources\Api\V1\SocialMedia\SocialMediaResource;
use App\Http\Resources\Api\V1\Wallet\WalletResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            //'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'father_name' => $this->father_name,
            'gender' => $this->gender,
            'nid' => $this->nid,
            'dob' => $this->dob,
            'mobile' => $this->mobile,
            'email' => $this->email,
            'image' => $this->image,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'authentication' => $this->authenticationStatus(),
            'addresses' => AddressResource::collection($this->whenLoaded('addresses')),
            'cards' => CardResource::collection($this->whenLoaded('cards')),
            'wallets' => WalletResource::collection($this->whenLoaded('wallets')),
            'social_media' => SocialMediaResource::collection($this->whenLoaded('socialMedia')),
        ];
    }
}
