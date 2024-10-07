<?php

namespace App\Models\Api\V1;

use App\Jobs\GetCardBankJob;
use App\Jobs\GetCardInformationJob;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Shetabit\Visitor\Traits\Visitable;

class Card extends Model
{
    use HasFactory, HasUuids, SoftDeletes, Visitable;

    protected $guarded = ['id'];

    protected static function boot()
    {
        parent::boot();

        static::created(static function ($card) {
            GetCardBankJob::dispatch($card)->afterCommit();
            GetCardInformationJob::dispatch($card)->afterCommit();
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
