<?php

namespace App\Http\Resources\Api\V1\Interest;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InterestResource extends JsonResource
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
            'upper_body_size' => $this->upper_body_size,
            'lower_body_size' => $this->lower_body_size,
            'shoe_size'       => $this->shoe_size,
            'favorite_color'  => $this->favorite_color,
            'favorite_food'   => $this->favorite_food,
            'interests'       => $this->interests,
            'personality'     => $this->personality,
            'fashion_style'   => $this->fashion_style,
            'gift_type'       => $this->gift_type,
            'description'     => $this->description,
            'created_at'      => $this->created_at,
            'updated_at'      => $this->updated_at,
        ];
    }
}
