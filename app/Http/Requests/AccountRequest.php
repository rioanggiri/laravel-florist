<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class AccountRequest extends FormRequest
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
            'photo' => 'sometimes|image|mimes:jpeg,png,jpg|max:1024',
            'name' => 'required|max:150',
            'email' => 'sometimes|email|unique:users,email,' . Auth::id(),
            'address' => 'sometimes',
            'phone' => 'sometimes',
        ];
    }
}
