<?php

namespace App\Http\Resources\Api\V1\Partnership;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PartnershipResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'           => $this->id,
            'first_name'   => $this->first_name,
            'last_name'    => $this->last_name,
            'company_name' => $this->company_name,
            'email'        => $this->email,
            'mobile'       => $this->mobile,
            'description'  => $this->description
        ];
    }
}
