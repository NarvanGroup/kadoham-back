<?php

namespace App\Http\Requests\Api\V1\Cards;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCardRequest extends FormRequest
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
        $ignore = null;

        if ($this->isMethod('PUT')) {
            $ignore = $this->card_number;
        }

        return [
            'card_number' => [
                'required',
                'ir_bank_card_number',
                Rule::unique('cards')->where(function ($query) {
                    return $query->where('user_id', $this->user()->id)->where('deleted_at', null);
                })->ignore($ignore, 'card_number')
            ]
        ];
    }
}
