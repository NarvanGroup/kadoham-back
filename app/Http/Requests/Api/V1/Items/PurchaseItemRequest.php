<?php

namespace App\Http\Requests\Api\V1\Items;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PurchaseItemRequest extends FormRequest
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
                Rule::unique('item_buyers', 'item_id'),
                Rule::exists('items', 'id')->where(static function ($query) {
                    $query->where('status', 'pending');
                })
            ],
            'is_public' => ['nullable', 'bool'],
            'buyers'    => ['nullable', 'array'],
            'content'   => ['required', 'string', 'min:3', 'max:6144'],
        ];
    }
}
