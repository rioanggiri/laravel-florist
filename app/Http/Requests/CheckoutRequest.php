<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
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
            'event_date' => 'required|date',
            'name' => 'required|max:150',
            'address' => 'required',
            // 'total_price' => 'required',
            'detail_order' => 'required',
            'phone' => 'required',
        ];
    }
}
