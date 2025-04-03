<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Password;

class SignupRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'email', 'unique:users,email'],              
            'password' => ['required', 'string', 'max:100', 'confirmed'],            
            'username' => ['required', 'string', 'max:50', 'unique:users,username'], 
            'phone' => ['nullable', 'string', 'max:10'],                            
            'businessName' => ['required', 'string', 'max:100'],                   
            'businessType' => ['required', 'exists:business_types,id'], 
        ];
    }

    public function messages()
    {
        return [
            'password.confirmed' => 'The password and confirm password do not match.',
        ];
    }
}
