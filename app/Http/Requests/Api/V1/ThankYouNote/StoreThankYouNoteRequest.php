<?php

namespace App\Http\Requests\Api\V1\ThankYouNote;

use App\Enums\ThankYouNotesEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreThankYouNoteRequest extends FormRequest
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
            'subject' => ['required', 'string', 'min:3', 'max:2048'],
            'content' => ['required', 'string', 'min:3', 'max:6144'],
            'type'    => ['required', 'string', Rule::in(ThankYouNotesEnum::cases())],
        ];
    }
}
