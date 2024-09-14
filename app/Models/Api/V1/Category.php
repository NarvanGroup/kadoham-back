<?php

namespace App\Models\Api\V1;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory, HasUuids;

    public function getRouteKeyName()
    {
        return 'slug';
    }

    protected $hidden = ['id'];

    protected $fillable = ['name_en', 'name_fa', 'slug'];

    public static array $allowedIncludes = ['subCategories', 'subCategories.products', 'blogs'];

    public function blogs(): HasMany
    {
        return $this->hasMany(Blog::class, 'category_id');
    }

    public function subCategories(): HasMany
    {
        return $this->hasMany(SubCategory::class, 'category_id');
    }
}
