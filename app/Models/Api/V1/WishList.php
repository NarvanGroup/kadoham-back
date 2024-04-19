<?php

namespace App\Models\Api\V1;

use App\Enums\ItemStatusEnum;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WishList extends Model
{
    use HasFactory, HasUuids;

    protected $guarded = [];

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
