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
        return [
            'user_id' => ['required', 'string', 'exists:users,id'],
            'card_number' => ['nullable', 'ir_bank_card_number', Rule::unique('cards')->where(function ($query) {
                return $query->where('user_id', $this->user()->id);
            })],
            'iban' => ['nullable', 'ir_sheba', Rule::unique('cards')->where(function ($query) {
                return $query->where('user_id', $this->user()->id);
            })],
            'card_number_or_iban' => 'required_without_all:card_number,iban'
        ];
    }
}
