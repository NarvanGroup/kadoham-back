<?php

namespace App\Models\Api\V1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Shetabit\Visitor\Traits\Visitable;

class Authentication extends Model
{
    use HasFactory, Visitable;

    protected $guarded = ['id'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
