<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCreditCardRequest extends FormRequest
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
            'user_id' => 'integer',
            'name' => 'string|max:31',
            'card_number' => 'unique:credit_cards|integer|digits:16',
            'expiration_year' => 'integer|digits:4|min:'.date('Y'),
            'expiration_month' => 'integer|digits:2|min:1|max:12',
            'phone' => 'string|min:19',
            'main' => 'boolean'
        ];
    }
}
