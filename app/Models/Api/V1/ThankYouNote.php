<?php

namespace App\Models\Api\V1;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Shetabit\Visitor\Traits\Visitable;

class ThankYouNote extends Model
{
    use HasFactory, HasUuids, Visitable;

    protected $fillable = [
        'type',
        'subject',
        'content',
        'file'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
