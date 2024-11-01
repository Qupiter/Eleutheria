<?php

namespace App\Services;

use App\Models\Account\User;
use App\Models\Account\UserRole;
use Illuminate\Support\Carbon;
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

        $tokenName = 'voting-api-token-' . $user->id;

        //TODO: maybe we need to add some logic around abilities
        // but I hope we can manage permissions only with the spatie/laravel-permission package
        $abilities = ['*'];

        // Set the expiration time to 30 minutes from now
        $expiresAt = Carbon::now()->addMinutes(30);

        // Generate and return token upon successful login
        return $user->createToken($tokenName, $abilities, $expiresAt)->plainTextToken;
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

        // default role
        $user->assignRole(UserRole::VOTER->value);

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
