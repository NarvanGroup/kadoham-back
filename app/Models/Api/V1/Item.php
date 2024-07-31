<?php

namespace App\Models\Api\V1;

use App\Enums\ItemTypeEnum;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $guarded = [];
    protected $casts = [
        'category' => 'json'
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function wishList()
    {
        return $this->belongsTo(WishList::class,'wish_list_id');
    }

    public function buyers()
    {
        return $this->hasMany(ItemBuyer::class);
    }

    protected function filled(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->type === ItemTypeEnum::PRODUCT->value ? $this->buyers()->sum('quantity') : $this->buyers()->sum('amount')
        );
    }

    protected function remaining(): Attribute
    {
        return Attribute::make(
            get: function () {
                if ($this->type === ItemTypeEnum::PRODUCT->value) {
                    return $this->quantity - $this->filled;
                }
                if($this->amount !== null){
                    return $this->amount - $this->filled;
                }
                return null;
            }
        );
    }
}
