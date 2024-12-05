<?php

namespace App\Services;

use App\Models\Account\User;
use App\Models\Account\UserRole;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Laravel\Sanctum\NewAccessToken;

class AuthService
{
    /**
     * Handle user login authentication.
     *
     * @param string $email
     * @param string $password
     * @return NewAccessToken
     * @throws ValidationException
     */
    public function authenticate(string $email, string $password): NewAccessToken
    {
        $user = User::where('email', $email)->first();

        if (!$user || !Hash::check($password, $user->password)) {
            throw ValidationException::withMessages([
                'credentials' => ['The provided credentials are incorrect.'],
            ]);
        }

        $tokenName = 'voting-api-token-' . $user->id;

        //TODO: maybe we need to add some logic around abilities
        // but I hope we can manage permissions only with the spatie/laravel-permission package
        $abilities = ['*'];

        // Set the expiration time to 30 minutes from now
        $expiresAt = Carbon::now()->addMinutes(30);

        // Generate and return token upon successful login
        return $user->createToken($tokenName, $abilities, $expiresAt);
    }

    /**
     * Register a new user as a VOTER.
     *
     * @param array $data
     * @return User
     */
    public function registerUser(array $data): User
    {
        $user = User::create([
            'first_name' => $data['first_name'],
            'last_name'  => $data['last_name'],
            'email'      => $data['email'],
            'password'   => Hash::make($data['password']),
            'phone'      => $data['phone'],
        ]);

        // default role VOTER
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
