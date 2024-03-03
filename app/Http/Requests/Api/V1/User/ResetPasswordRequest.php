<?php

namespace App\Http\Requests\Api\V1\User;

use Closure;
use Hash;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class ResetPasswordRequest extends FormRequest
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
        return [
            'current_password' => [
                Rule::requiredIf($user->password !== null),
                Rule::excludeIf($user->password === null),
                static function (string $attribute, mixed $value, Closure $fail) use ($user) {
                    if (!Hash::check($value, $user->password)) {
                        $fail("The {$attribute} is incorrect.");
                    }
                },
            ],
            'new_password'     => [
                'required',
                'different:current_password',
                'confirmed',
                Password::min(8)->letters()->mixedCase()->numbers()
            ]
        ];
    }
}
