<?php

namespace App\Http\Requests\Api\V1\Items;

use App\Enums\ItemStatusEnum;
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
        return [
            'item_id'   => [
                'required',
                Rule::exists('item_buyers', 'item_id')->where(function ($query) {
                    $query->where('user_id', $this->user()->id);
                }),
                Rule::exists('items', 'id')->where(static function ($query) {
                    $query->where('status', ItemStatusEnum::COMPLETED);
                })
            ]
        ];
    }
}
