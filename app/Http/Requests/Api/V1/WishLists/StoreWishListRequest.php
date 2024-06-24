<?php

namespace App\Http\Requests\Api\V1\WishLists;

use App\Enums\VisibilityEnum;
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

        $rules = [
            'name'        => [
                'required',
                'string',
                'max:255',
                Rule::unique('wish_lists')->where('user_id', auth()->user()->id)->ignore($ignoreName, 'name')
            ],
            'visibility'   => ['nullable', 'string', Rule::in(VisibilityEnum::cases())],
            'description' => ['nullable', 'string', 'max:4096'],
            'occasion_date' => ['nullable','date','after_or_equal:today'],
            'status'      => ['nullable', 'string', Rule::in(WishlistStatusEnum::cases())],
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
