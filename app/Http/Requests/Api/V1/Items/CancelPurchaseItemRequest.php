<?php

namespace App\Http\Requests\Api\V1\Items;

use App\Enums\ItemStatusEnum;
use App\Models\Api\V1\Item;
use App\Models\Api\V1\ItemBuyer;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CancelPurchaseItemRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, Rule|array|string>
     */
    public function rules(): array
    {
        $itemBuyer = ItemBuyer::findOrFail($this->item_buyer_id);
        $item = $itemBuyer->item;
        return [
            'item_buyer_id'   => [
                'required',
                Rule::exists('item_buyers', 'id')->where(function ($query) use ($item) {
                    $query->where('user_id', $this->user()->id)
                        ->orWhere('user_id', $item->user_id);
                })
            ]
        ];
    }
}
