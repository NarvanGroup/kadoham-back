<?php

namespace App\Models\Api\V1;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ItemBuyer extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'item_id',
        'content',
        'buyers',
        'is_public'
    ];

    protected $casts = [
        'buyers' => 'json',
        'is_public' => 'boolean'
    ];

    /**
     * @return HasMany
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return HasMany
     */
    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }
}
