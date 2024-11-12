<?php

namespace App\Http\Requests\Account;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'firstName'   => 'required|string|max:255',
            'lastName'    => 'required|string|max:255',
            'email'       => 'required|string|email|max:255|unique:users',
            'password'    => 'required|string|min:8|confirmed',
            'phoneNumber' => 'required|string|max:20',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'firstName.required' => 'First name is required.',
            'firstName.string'   => 'First name must be a valid string.',
            'firstName.max'      => 'First name cannot exceed 255 characters.',

            'lastName.required'  => 'Last name is required.',
            'lastName.string'    => 'Last name must be a valid string.',
            'lastName.max'       => 'Last name cannot exceed 255 characters.',

            'email.required'     => 'Email address is required.',
            'email.string'       => 'Email must be a valid string.',
            'email.email'        => 'Please provide a valid email address.',
            'email.max'          => 'Email cannot exceed 255 characters.',
            'email.unique'       => 'An account with this email already exists.',

            'password.required'  => 'Password is required.',
            'password.string'    => 'Password must be a valid string.',
            'password.min'       => 'Password must be at least 8 characters long.',
            'password.confirmed' => 'Password confirmation does not match.',

            'phoneNumber.required' => 'Phone number is required.',
            'phoneNumber.string'   => 'Phone number must be a valid string.',
            'phoneNumber.max'      => 'Phone number cannot exceed 20 characters.',
        ];
    }
}
