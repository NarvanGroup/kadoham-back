<?php

namespace App\Http\Requests\Api\V1\Items;

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
        return [
            'user_id' => ['required', 'string', 'exists:sso.users,mobile'],
            'name' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'max_digits:20'],
            'link' => ['nullable', 'string', 'max:2048'],
            'quantity' => ['nullable', 'numeric', 'max_digits:3'],
            'image' => ['nullable', 'string', 'max:2048'],
            'where_to_buy' => ['nullable', 'string', 'max:255'],
            'rate' => ['nullable', 'numeric', 'min:0','max:5'],
            'description' => ['nullable', 'string', 'max:4096'],
            'wish_list_id' => ['required', 'string', 'exists:wish_lists,id'],
        ];
    }
}
