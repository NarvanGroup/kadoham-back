<?php

namespace App\Http\Requests\Api\V1\User;

use App\Enums\GendersEnum;
use Closure;
use Hash;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UpdateProfileRequest extends FormRequest
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
        $user = auth()->user();

        $rules = [
            'first_name' => [
                'nullable',
                'string',
                'max:255',
            ],
            'last_name' => [
                'nullable',
                'string',
                'max:255',
            ],
            'father_name' => [
                'nullable',
                'string',
                'max:255',
            ],
            'dob' => [
                'nullable',
                'date',
                'before:today'
            ],
            'username' => [
                'nullable',
                'string',
                'alpha_num',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            'gender' => [
                'nullable',
                Rule::in(GendersEnum::cases()),
            ],
            'email' => [
                'nullable',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ]
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
