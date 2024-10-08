<?php

namespace App\Models\Api\V1;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Shetabit\Visitor\Traits\Visitable;

class Interest extends Model
{
    use HasFactory, HasUuids, Visitable;

    protected $guarded = [];

    protected $casts = [
        'interests' => 'json',
        'favorite_color' => 'json',
        'favorite_food' => 'json',
        'fashion_style' => 'json',
        'gift_type' => 'json'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
