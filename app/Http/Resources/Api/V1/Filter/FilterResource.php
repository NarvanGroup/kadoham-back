<?php

namespace App\Http\Resources\Api\V1\Filter;

use App\Http\Resources\Api\V1\Item\ItemResource;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FilterResource extends JsonResource
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
            'id' => $this->id,
            'name' => $this->name,
            'options' => $this->options,
        ];
    }
}
