<?php

namespace App\Http\Requests\Api\V1\Price;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GetPriceRequest extends FormRequest
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
            'url' => ['required', 'string', 'url']
        ];
    }
}
