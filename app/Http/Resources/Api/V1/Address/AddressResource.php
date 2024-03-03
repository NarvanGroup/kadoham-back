<?php

namespace App\Http\Resources\Api\V1\Address;

use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'province_id' => $this->province_id,
            'city_id' => $this->city_id,
            'address' => $this->address,
            'unit' => $this->unit,
            'number' => $this->number,
            'postal_code' => $this->postal_code,
            'isReceiver' => $this->isReceiver,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'mobile' => $this->mobile,
        ];
    }
}
