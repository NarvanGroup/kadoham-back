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
            'name'         => [
                'required',
                'string',
                'max:255',
                Rule::unique('items')->where('user_id', auth()->user()->id)
                    ->where('wish_list_id', $this->wish_list_id)
                    ->ignore($ignoreName, 'name')
            ],
            'type'         => ['nullable', 'string', Rule::in(ItemTypeEnum::cases())],
            'price'        => ['required', 'numeric', 'max_digits:20'],
            'link'         => ['nullable', 'string', 'max:2048'],
            'quantity'     => ['nullable', 'numeric', 'max_digits:3'],
            'where_to_buy' => ['nullable', 'string', 'max:255'],
            'rate'         => ['nullable', 'numeric', 'min:0', 'max:5'],
            'description'  => ['nullable', 'string', 'max:4096'],
            'category'     => ['nullable', 'json'],
            'amount'       => ['nullable', 'numeric', 'min:1000'],
            'charity'      => ['nullable', 'json'],
            'visibility'   => ['nullable', 'string', Rule::in(VisibilityEnum::cases())],
            'status'       => ['nullable', 'string', Rule::in(ItemStatusEnum::cases())],
            'wish_list_id' => ['required', 'string', Rule::exists('wish_lists', 'id'), Rule::in(auth()->user()->wishLists()->pluck('id'))],
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
