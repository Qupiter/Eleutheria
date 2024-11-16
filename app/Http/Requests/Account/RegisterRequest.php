<?php

namespace App\Http\Requests\Account;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="RegisterRequest",
 *     type="object",
 *     required={"firstName", "lastName", "email", "password", "phone"},
 *     @OA\Property(
 *         property="firstName",
 *         type="string",
 *         description="The user's first name",
 *         example="John",
 *         maxLength=255
 *     ),
 *     @OA\Property(
 *         property="lastName",
 *         type="string",
 *         description="The user's last name",
 *         example="Doe",
 *         maxLength=255
 *     ),
 *     @OA\Property(
 *         property="email",
 *         type="string",
 *         format="email",
 *         description="The user's email address",
 *         example="johndoe@example.com",
 *         maxLength=255
 *     ),
 *     @OA\Property(
 *         property="password",
 *         type="string",
 *         format="password",
 *         description="The user's password (must be at least 8 characters)",
 *         example="secret123"
 *     ),
 *     @OA\Property(
 *         property="password_confirmation",
 *         type="string",
 *         format="password",
 *         description="The confirmation of the user's password",
 *         example="secret123"
 *     ),
 *     @OA\Property(
 *         property="phone",
 *         type="string",
 *         description="The user's phone number",
 *         example="+1234567890",
 *         maxLength=20
 *     )
 * )
 */
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'firstName' => 'required|string|max:255',
            'lastName'  => 'required|string|max:255',
            'email'     => 'required|string|email|max:255|unique:users',
            'password'  => 'required|string|min:8|confirmed',
            'phone'     => 'required|string|max:20',
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

            'lastName.required' => 'Last name is required.',
            'lastName.string'   => 'Last name must be a valid string.',
            'lastName.max'      => 'Last name cannot exceed 255 characters.',

            'email.required' => 'Email address is required.',
            'email.string'   => 'Email must be a valid string.',
            'email.email'    => 'Please provide a valid email address.',
            'email.max'      => 'Email cannot exceed 255 characters.',
            'email.unique'   => 'An account with this email already exists.',

            'password.required'  => 'Password is required.',
            'password.string'    => 'Password must be a valid string.',
            'password.min'       => 'Password must be at least 8 characters long.',
            'password.confirmed' => 'Password confirmation does not match.',

            'phone.required' => 'Phone number is required.',
            'phone.string'   => 'Phone number must be a valid string.',
            'phone.max'      => 'Phone number cannot exceed 20 characters.',
        ];
    }
}
