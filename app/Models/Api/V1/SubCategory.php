<?php

namespace App\Models\Api\V1;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SubCategory extends Model
{
    use HasFactory, HasUuids;

    public function getRouteKeyName()
    {
        return 'slug';
    }

    protected $hidden = ['id'];

    protected $fillable = ['name_en', 'name_fa', 'slug', 'category_id'];

    public static array $allowedIncludes = ['category', 'blogs'];


    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function blogs(): HasMany
    {
        return $this->hasMany(Blog::class, 'sub_category_id');
    }
}
