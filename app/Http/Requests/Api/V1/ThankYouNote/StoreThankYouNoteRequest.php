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
        $rules = [
            'subject' => ['required', 'string', 'min:3', 'max:2048'],
            'content' => ['required', 'string', 'min:3', 'max:6144'],
            'type'    => ['required', 'string', Rule::in(ThankYouNotesEnum::cases())],
        ];

        if ($this->input('type') === ThankYouNotesEnum::TEXT->value) {
            $rules['content'] = ['required', 'string', 'min:100', 'max:4096'];
        } elseif ($this->input('type') === ThankYouNotesEnum::IMAGE->value) {
            $rules['file'] = ['required', 'image', 'mimes:jpg,jpeg,png,gif,svg', 'max:5120'];
        } elseif ($this->input('type') === ThankYouNotesEnum::VOICE->value) {
            $rules['file'] = ['required', 'file', 'mimes:mp3,wav,aac', 'max:5120'];
        } elseif ($this->input('type') === ThankYouNotesEnum::VIDEO->value) {
            $rules['file'] = ['required', 'file', 'mimes:mp4,mkv,avi,wmv,mov', 'max:10240'];
        }

        return $rules;
    }
}
