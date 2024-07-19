<?php

namespace App\Models\Api\V1;

use App\Enums\ItemStatusEnum;
use App\Helper\UniqueCodeGenerator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WishList extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $guarded = [];

    // Use the created event to created share link
    protected static function boot()
    {
        parent::boot();

        static::created(static function ($wishList) {
            $code = UniqueCodeGenerator::generateUniqueCode(new self(), 'share');
            $wishList->update(['share' => $code]);
        });
    }

    /**
     * Scope a query to only include popular users.
     */
    public function scopePublic(Builder $query): void
    {
        $query->where('visibility', 'public');
    }

    public function scopeSearch($query, $searchTerm)
    {
        return $query->public()->where(function ($query) use ($searchTerm) {
            $query->where('name', 'like', "%{$searchTerm}%")
                ->orWhere('description', 'like', "%{$searchTerm}%");
        });
    }

    protected function itemsCount(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->items()->count(),
        );
    }

    protected function progress(): Attribute
    {
        $totalItems = $this->items()->count();
        $completedItems = $this->items()->whereIn('status', [ItemStatusEnum::RESERVED, ItemStatusEnum::COMPLETED])->count();
        $progress = $totalItems > 0 ? ($completedItems / $totalItems) * 100 : 0;
        return Attribute::make(
            get: static fn () => (int) round($progress),
        );
    }

    public function items()
    {
        return $this->hasMany(Item::class,'wish_list_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
