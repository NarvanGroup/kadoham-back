<?php

namespace App\Http\Requests\Api\V1\User;

use App\Enums\GendersEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SearchRequest extends FormRequest
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
            'search' => [
                'required',
                'min:3',
                'max:255',
                'alpha_dash:ascii'
            ]
        ];
    }
}
