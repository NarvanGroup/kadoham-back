<?php

namespace App\Http\Requests\Api\V1\Items;

use App\Enums\VisibilityEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreItemRequest extends FormRequest
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
            'name'         => [
                'required',
                'string',
                'max:255',
                Rule::unique('items')->where('user_id', auth()->user()->id)->where('wish_list_id', $this->wish_list_id)
            ],
            'price'        => ['required', 'numeric', 'max_digits:20'],
            'link'         => ['nullable', 'string', 'max:2048'],
            'quantity'     => ['nullable', 'numeric', 'max_digits:3'],
            'image'        => ['nullable', 'string', 'max:2048'],
            'where_to_buy' => ['nullable', 'string', 'max:255'],
            'rate'         => ['nullable', 'numeric', 'min:0', 'max:5'],
            'description'  => ['nullable', 'string', 'max:4096'],
            'visibility'   => ['nullable', 'string', Rule::in(VisibilityEnum::cases())],
            'wish_list_id' => ['required', 'string', Rule::exists('wish_lists', 'id'), Rule::in(auth()->user()->wishlist()->pluck('id'))],
        ];
    }
}
