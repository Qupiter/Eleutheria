<?php

namespace App\Services;

use App\Models\Account\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthService
{
    /**
     * Handle user login authentication.
     *
     * @param string $email
     * @param string $password
     * @return string
     * @throws ValidationException
     */
    public function authenticate(string $email, string $password): string
    {
        $user = User::where('email', $email)->first();

        if (!$user || !Hash::check($password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        // Generate and return token upon successful login
        return $user->createToken('api-token')->plainTextToken;
    }

    /**
     * Register a new user.
     *
     * @param array $data
     * @return User
     */
    public function registerUser(array $data): User
    {
        $user = User::create([
            'first_name'  => $data['firstName'],
            'last_name'   => $data['lastName'],
            'email'       => $data['email'],
            'password'    => Hash::make($data['password']),
            'phoneNumber' => $data['phoneNumber'],
        ]);

        //TODO:: 'voter' string could be UserRole enum type
        $user->assignRole('voter');

        return $user;
    }

    /**
     * Log out a user by deleting all tokens.
     *
     * @param User $user
     * @return void
     */
    public function logoutUser(User $user): void
    {
        $user->tokens()->delete();
    }
}
