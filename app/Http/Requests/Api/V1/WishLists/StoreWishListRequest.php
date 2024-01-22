<?php

namespace App\Http\Requests\Api\V1\WishLists;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreWishListRequest extends FormRequest
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
            'description' => ['nullable', 'string','max:4096'],
        ];
    }
}
