<?php

namespace App\Http\Requests\Api\V1\SocialMedia;

use App\Enums\SocialMediaEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreSocialMediaRequest extends FormRequest
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
            'user_id'  => ['required', 'string', 'exists:users,id'],
            'name'     => [
                'required',
                'string',
                Rule::in(SocialMediaEnum::names()),
            ],
            'username' => [
                'required',
                'string',
                'max:255',
                Rule::unique('social_media')->where('user_id', auth()->user()->id)->ignore(auth()->user()->id, 'user_id')
            ]
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge(['name' => strtoupper($this->name)]);
    }
}
