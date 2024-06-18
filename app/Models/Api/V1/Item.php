<?php

namespace App\Models\Api\V1;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $guarded = [];
    public function wishList()
    {
        return $this->belongsTo(WishList::class,'wish_list_id');
    }

    public function buyer()
    {
        return $this->hasOne(ItemBuyer::class);
    }
}
