<?php

namespace App\Models\Api\V1;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WishList extends Model
{
    use HasFactory, HasUuids;

    protected $guarded = [];

    public function items()
    {
        return $this->hasMany(Item::class,'wish_list_id');
    }
}
