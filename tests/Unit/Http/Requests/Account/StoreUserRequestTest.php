<?php

namespace Tests\Http\Requests\Account;

use App\Http\Requests\Account\StoreUserRequest;
use App\Models\Account\UserRole;
use Illuminate\Support\Facades\Auth;
use Tests\Http\Requests\RequestTest;

class StoreUserRequestTest extends RequestTest
{
    public function setUp(): void
    {
        parent::setUp();
        $this->request = new StoreUserRequest();
    }

    public function testAuthorization(): void
    {
        $adminUser = $this->mockUserWithRole(UserRole::ADMIN);

        Auth::shouldReceive('check')->andReturn(true);
        Auth::shouldReceive('user')->andReturn($adminUser);

        $this->assertTrue($this->request->authorize());
    }

    public function testAuthorizationFailsForNonAdmin(): void
    {
        $regularUser = $this->mockUserWithRole(UserRole::VOTER);

        Auth::shouldReceive('check')->andReturn(true);
        Auth::shouldReceive('user')->andReturn($regularUser);

        $this->assertFalse($this->request->authorize());
    }

    public function testSuccess(): void
    {
        $data = [
            'first_name' => 'John',
            'last_name'  => 'Doe',
            'email'      => 'test@example.com',
            'password'   => 'securepassword123',
            'phone'      => '+1234567890',
        ];
        $this->validateRequest($data, []);
    }

    public function testMissingFirstName(): void
    {
        $data           = [
            'last_name' => 'Doe',
            'email'     => 'test@example.com',
            'password'  => 'securepassword123',
            'phone'     => '+1234567890',
        ];
        $expectedErrors = ['first_name' => ['First name is required.']];
        $this->validateRequest($data, $expectedErrors);
    }

    public function testMissingLastName(): void
    {
        $data           = [
            'first_name' => 'John',
            'email'      => 'test@example.com',
            'password'   => 'securepassword123',
            'phone'      => '+1234567890',
        ];
        $expectedErrors = ['last_name' => ['Last name is required.']];
        $this->validateRequest($data, $expectedErrors);
    }

    public function testInvalidEmail(): void
    {
        $data           = [
            'first_name' => 'John',
            'last_name'  => 'Doe',
            'email'      => 'not-an-email',
            'password'   => 'securepassword123',
            'phone'      => '+1234567890',
        ];
        $expectedErrors = ['email' => ['The email field must be a valid email address.']];
        $this->validateRequest($data, $expectedErrors);
    }

    public function testMissingPassword(): void
    {
        $data           = [
            'first_name' => 'John',
            'last_name'  => 'Doe',
            'email'      => 'test@example.com',
            'phone'      => '+1234567890',
        ];
        $expectedErrors = ['password' => ['Password is required.']];
        $this->validateRequest($data, $expectedErrors);
    }

    public function testPhoneMaxLength(): void
    {
        $data           = [
            'first_name' => 'John',
            'last_name'  => 'Doe',
            'email'      => 'test@example.com',
            'password'   => 'securepassword123',
            'phone'      => str_repeat('1', 16),
        ];
        $expectedErrors = ['phone' => ['The phone field must not be greater than 15 characters.']];
        $this->validateRequest($data, $expectedErrors);
    }

    public function testMissingRequiredFields(): void
    {
        $data           = [];
        $expectedErrors = [
            'first_name' => ['First name is required.'],
            'last_name'  => ['Last name is required.'],
            'email'      => ['Email is required.'],
            'password'   => ['Password is required.'],
        ];
        $this->validateRequest($data, $expectedErrors);
    }
}
