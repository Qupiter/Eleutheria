<?php

namespace App\Http\Requests\Account;

use App\Models\Account\UserRole;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

/**
 * @OA\Schema(
 *     schema="StoreUserRequest",
 *     type="object",
 *     required={"first_name", "last_name", "email", "password"},
 *     @OA\Property(
 *         property="first_name",
 *         type="string",
 *         description="The user's first name",
 *         example="John",
 *         maxLength=255
 *     ),
 *     @OA\Property(
 *         property="last_name",
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
 *         example="securepassword123"
 *     ),
 *     @OA\Property(
 *         property="phone",
 *         type="string",
 *         description="The user's phone number",
 *         example="+1234567890",
 *         maxLength=15,
 *         nullable=true
 *     ),
 *     @OA\Property(
 *         property="is_active",
 *         type="boolean",
 *         description="Indicates if the user is active",
 *         example=true,
 *         nullable=true
 *     )
 * )
 */
class StoreUserRequest extends FormRequest
{

    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return Auth::check() && Auth::user()->hasRole(UserRole::ADMIN->value);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'email'      => 'required|email|unique:users,email',
            'password'   => 'required|string|min:8',
            'phone'      => 'nullable|string|max:15',
            'is_active'  => 'nullable|boolean',
        ];
    }

    /**
     * Customize the error messages for validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'first_name.required' => 'First name is required.',
            'last_name.required'  => 'Last name is required.',
            'email.required'      => 'Email is required.',
            'email.unique'        => 'This email is already registered.',
            'password.required'   => 'Password is required.',
        ];
    }
}
