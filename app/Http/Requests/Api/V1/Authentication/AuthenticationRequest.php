<?php

namespace App\Http\Requests\Api\V1\Authentication;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AuthenticationRequest extends FormRequest
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
            'first_name' => ['required', 'persian_alpha', 'min:2', 'max:255'],
            'last_name' => ['required', 'persian_alpha', 'min:2', 'max:255'],
            'father_name' => ['required', 'persian_alpha', 'min:2', 'max:255'],
            'nid' => ['required', 'ir_national_code', Rule::unique('users')->ignore($this->user()->id)],
            'dob' => ['required', 'shamsi_date'],
            'image' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:1000', 'dimensions:min_width=300,min_height=200', new IdCardImage()],
            'email' => ['nullable', 'email', 'unique:users']
        ];
    }
}
