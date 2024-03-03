<?php

namespace App\Http\Requests\Api\V1\WishLists;

use App\Models\Api\V1\WishList;
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
            'name' => ['required', 'string', 'max:255',Rule::unique('wish_lists')->where('user_id',auth()->user()->id)],
            'description' => ['nullable', 'string','max:4096'],
        ];
    }
}
