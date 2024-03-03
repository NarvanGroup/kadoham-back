<?php

namespace App\Http\Resources\Api\V1\SocialMedia;

use Illuminate\Http\Resources\Json\JsonResource;

class SocialMediaResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'       => $this->id,
            'name'     => $this->name,
            'username' => $this->username
        ];
    }
}
