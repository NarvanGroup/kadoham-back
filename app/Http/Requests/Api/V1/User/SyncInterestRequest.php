<?php

namespace App\Http\Requests\Api\V1\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SyncInterestRequest extends FormRequest
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
            'upper_body_size' => 'nullable|string',
            'lower_body_size' => 'nullable|string',
            'shoe_size'       => 'nullable|string',
            'favorite_color'  => 'nullable|array',
            'favorite_food'   => 'nullable|array',
            'interests'       => 'nullable|array',
            'personality'     => 'nullable|string',
            'fashion_style'   => 'nullable|array',
            'gift_type'       => 'nullable|array',
            'description'     => 'nullable|string'
        ];
    }
}
