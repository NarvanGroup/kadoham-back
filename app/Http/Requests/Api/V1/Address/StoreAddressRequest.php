<?php

namespace App\Http\Requests\Api\V1\Address;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreAddressRequest extends FormRequest
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
            'province_id' => ['required', 'integer', 'exists:iran_provinces,id'],
            'city_id' => [
                'required',
                'integer',
                Rule::exists('iran_cities', 'id')->where(function ($query) {
                    $query->where('province_id', $this->province_id);
                })
            ],
            'address' => ['required', 'string', 'max:255'],
            'unit' => ['required', 'string'],
            'number' => ['required', 'string'],
            'postal_code' => ['nullable', 'ir_postal_code'],
            'isReceiver' => ['required', 'boolean'],
            'mobile' => ['exclude_if:isReceiver,true', 'ir_mobile:zero'],
            'first_name' => ['exclude_if:isReceiver,true', 'persian_alpha', 'min:2', 'max:255'],
            'last_name' => ['exclude_if:isReceiver,true', 'persian_alpha', 'min:2', 'max:255'],
        ];
    }
}
