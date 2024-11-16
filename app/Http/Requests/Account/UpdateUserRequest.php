<?php

namespace App\Http\Requests\Account;

use App\Models\Account\User;
use App\Models\Account\UserRole;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

/**
 * @OA\Schema(
 *     schema="UpdateUserRequest",
 *     type="object",
 *     @OA\Property(
 *         property="first_name",
 *         type="string",
 *         description="The user's first name",
 *         example="John",
 *         maxLength=255,
 *         nullable=true
 *     ),
 *     @OA\Property(
 *         property="last_name",
 *         type="string",
 *         description="The user's last name",
 *         example="Doe",
 *         maxLength=255,
 *         nullable=true
 *     ),
 *     @OA\Property(
 *         property="email",
 *         type="string",
 *         format="email",
 *         description="The user's email address",
 *         example="johndoe@example.com",
 *         maxLength=255,
 *         nullable=true
 *     ),
 *     @OA\Property(
 *         property="password",
 *         type="string",
 *         format="password",
 *         description="The user's password (must be at least 8 characters)",
 *         example="securepassword123",
 *         nullable=true
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
class UpdateUserRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize(): bool
    {
        /** @var User $user */
        $user = Auth::user();

        return Auth::check() &&
            (
                $user->hasRole(UserRole::ADMIN->value) ||
                $user->id == $this->route('id')
            );
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => 'sometimes|required|string|max:255',
            'last_name'  => 'sometimes|required|string|max:255',
            'email'      => "sometimes|required|email|unique:users,email,{$this->route('user')}",
            'password'   => 'sometimes|nullable|string|min:8',
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
        ];
    }
}
