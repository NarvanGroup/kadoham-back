<?php

namespace App\Models\Api\V1;

use Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Blog extends Model
{
    use HasFactory, HasUuids;

    public function getRouteKeyName()
    {
        return 'slug';
    }

    protected $hidden = ['id'];

    protected $fillable = [
        'name_en',
        'name_fa',
        'slug',
        'content',
        'images',
        'description',
        'user_id',
        'keywords',
        'tags',
        'category_id',
        'sub_category_id'
    ];

    public static array $allowedIncludes = ['user', 'category', 'subCategory'];

    protected $casts = [
        'images'   => 'array',
        'keywords' => 'json',
        'tags'     => 'array',
    ];

    protected function images(): Attribute
    {
        return Attribute::make(get: static fn(string $value) => collect($value)->map(static fn($image) => env('APP_URL').'/images/'.$image));
    }



    /**
     * Get product category
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get product category
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    /**
     * Get product subcategory
     */
    public function subCategory(): BelongsTo
    {
        return $this->belongsTo(SubCategory::class, 'sub_category_id');
    }
}
