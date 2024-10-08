<?php

namespace App\Http\Requests\Api\V1\Items;

use App\Enums\ItemStatusEnum;
use App\Enums\ItemTypeEnum;
use App\Enums\VisibilityEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreItemRequest extends FormRequest
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
        $ignoreName = null;

        if ($this->isMethod('PUT')) {
            $ignoreName = $this->name;
        }

        $rules = [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('items')->where('user_id', auth()->user()->id)
                    ->where('wish_list_id', $this->wish_list_id)
                    ->ignore($ignoreName, 'name')
            ],
            'type' => ['required', 'string', Rule::in(ItemTypeEnum::cases())],
            'price' => [
                Rule::excludeIf($this->type !== ItemTypeEnum::PRODUCT->value),
                'numeric',
                'min:1000',
                'max_digits:9'
            ],
            'link' => ['nullable', 'string', 'max:2048'],
            'quantity' => [
                Rule::excludeIf($this->type !== ItemTypeEnum::PRODUCT->value),
                'numeric',
                'min:1',
                'max_digits:6'
            ],
            'where_to_buy' => ['nullable', 'string', 'max:255'],
            'rate' => ['nullable', 'numeric', 'min:0', 'max:5'],
            'description' => ['nullable', 'string', 'max:4096'],
            'category' => [
                Rule::excludeIf($this->type !== ItemTypeEnum::EXPERIENCE->value),
                'json'
            ],
            'amount' => [
                Rule::excludeIf($this->type !== ItemTypeEnum::CHARITY->value && $this->type !== ItemTypeEnum::CASH->value),
                'nullable',
                'numeric',
                'min:1000',
                'max_digits:9'
            ],
            'charity' => ['nullable', 'json'],
            'visibility' => ['nullable', 'string', Rule::in(VisibilityEnum::cases())],
            'status' => ['nullable', 'string', Rule::in(ItemStatusEnum::cases())],
            'wish_list_id' => [
                'required',
                'string',
                Rule::exists('wish_lists', 'id'),
                Rule::in(auth()->user()->wishLists()->pluck('id'))
            ],
        ];

        if ($this->is_upload) {
            $rules['image'] = [
                'nullable',
                'image',
                'mimes:png,jpg,webp,gif',
                'max:512'
            ];
        } else {
            $rules['image'] = 'nullable|url';
        }

        return $rules;
    }
}
