<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCreditCardRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'user_id' => 'required|integer',
            'name' => 'string|max:31',
            'card_number' => 'required|unique:credit_cards|integer|digits:16',
            'expiration_year' => 'required|integer|digits:2|after_or_equal:'.date('Y'),
            'expiration_month' => 'required|integer|digits:2|min:1|max:12',
            'phone' => 'required|string|min:19',
            'main' => 'boolean'
        ];
    }
}
