<?php

namespace App\Http\Requests\Api\V1\WishLists;

use App\Enums\WishlistStatusEnum;
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
        $ignoreName = null;

        if ($this->isMethod('PUT')) {
            $ignoreName = $this->name;
        }

        return [
            'name'        => [
                'required',
                'string',
                'max:255',
                Rule::unique('wish_lists')->where('user_id', auth()->user()->id)->ignore($ignoreName, 'name')
            ],
            'description' => ['nullable', 'string', 'max:4096'],
            'status'      => ['nullable', 'string', Rule::in(WishlistStatusEnum::cases())],
        ];
    }
}
