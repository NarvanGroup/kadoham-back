<?php

namespace App\Models\Api\V1;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ThankYouNote extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'type',
        'subject',
        'content'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
