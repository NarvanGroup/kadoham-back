<?php

namespace App\Http\Requests\Api\V1\WishLists;

use App\Enums\WishlistStatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ShareWishListRequest extends FormRequest
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
            'wish_list_id'        => [
                'required',
                Rule::exists('wish_lists')
                    ->where('share', null)
                    ->where('user_id', $this->user()->id)
            ]
        ];
    }
}
