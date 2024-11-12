<?php

namespace App\Http\Requests\Account;

use App\Models\Account\User;
use App\Models\Account\UserRole;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class UserRoleRequest extends FormRequest
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
     * @return array
     */
    public function rules(): array
    {
        return [
            'userId'   => [
                'required',
                'integer',
                Rule::exists(User::class, 'id'),
            ],
            'roleName' => [
                'required',
                'string',
                Rule::exists(Role::class, 'name'),
            ],
        ];
    }

    /**
     * Custom messages for validation errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'userId.required'   => 'The user ID is required.',
            'userId.integer'    => 'The user ID must be an integer.',
            'userId.exists'     => 'The specified user does not exist.',
            'roleName.required' => 'The role name is required.',
            'roleName.string'   => 'The role name must be a valid string.',
            'roleName.exists'   => 'The specified role does not exist.',
        ];
    }
}
