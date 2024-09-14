<?php

namespace App\Http\Requests\Api\V1\Items;

use App\Enums\ItemStatusEnum;
use App\Enums\ItemTypeEnum;
use App\Models\Api\V1\Item;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PurchaseItemRequest extends FormRequest
{
    protected $item;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $this->item = Item::findOrFail($this->item_id);
        $itemType = $this->item->type;

        $isQuantityRequired = $itemType === ItemTypeEnum::PRODUCT->value;
        $isAmountRequired = in_array($itemType, [ItemTypeEnum::CASH->value, ItemTypeEnum::CHARITY->value], true);

        return [
            'item_id' => [
                'required',
                Rule::exists('items', 'id')->where('status', ItemStatusEnum::PENDING)
            ],
            'quantity' => $this->getQuantityRules($isQuantityRequired),
            'amount' => $this->getAmountRules($isAmountRequired),
            'is_public' => ['nullable', 'bool'],
            'buyers' => ['nullable', 'array'],
            'content' => ['nullable', 'string', 'min:3', 'max:6144'],
        ];
    }

    private function getQuantityRules(bool $isQuantityRequired): array
    {
        if (!$isQuantityRequired) {
            return ['nullable', 'numeric'];
        }

        return ['required', 'numeric','min:1', 'max_digits:6', 'lte:' . $this->item->remaining];
    }

    private function getAmountRules(bool $isAmountRequired): array
    {
        if (!$isAmountRequired || $this->item->amount === null) {
            return ['nullable', 'numeric', 'min: 1000', 'max_digits:9'];
        }

        return ['required', 'numeric', 'min: 1000', 'max_digits:9', 'lte:' . $this->item->remaining];
    }
}
