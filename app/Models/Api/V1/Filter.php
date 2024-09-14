<?php

namespace App\Models\Api\V1;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Shetabit\Visitor\Traits\Visitable;

class Filter extends Model
{
    use HasFactory, HasUuids, Visitable;

    protected $fillable = ['name', 'options'];

    protected $casts = [
        'options' => 'json',
    ];
}
