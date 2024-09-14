<?php

namespace App\Http\Resources\Api\V1\Blog;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BlogResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'name_en'     => $this->name_en,
            'name_fa'     => $this->name_fa,
            'slug'        => $this->slug,
            'content'     => $this->content,
            'images'      => $this->images,
            'description' => $this->description,
            'keywords'    => $this->keywords,
            'tags'        => $this->tags,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
