<?php

namespace App\Http\Requests\Account;

use App\Models\Account\User;
use App\Models\Account\UserRole;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

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
