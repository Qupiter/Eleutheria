<?php

namespace Tests\Http\Requests\Account;

use App\Http\Requests\Account\RegisterRequest;
use Tests\Http\Requests\RequestTest;

class RegisterRequestTest extends RequestTest
{
    public function setUp(): void
    {
        parent::setUp();
        $this->request = new RegisterRequest();
    }

    public function testAuthorize(): void
    {
        $this->assertTrue($this->request->authorize());
    }

    public function testSuccess(): void
    {
        $data = [
            'first_name'            => 'John',
            'last_name'             => 'Doe',
            'email'                 => 'test@example.com',
            'password'              => 'secret123',
            'password_confirmation' => 'secret123',
            'phone'                 => '+1234567890',
        ];
        $this->validateRequest($data, []);
    }

    public function testMissingFirstName(): void
    {
        $data           = [
            'last_name'             => 'Doe',
            'email'                 => 'test@example.com',
            'password'              => 'secret123',
            'password_confirmation' => 'secret123',
            'phone'                 => '+1234567890',
        ];
        $expectedErrors = ['first_name' => ['First name is required.']];
        $this->validateRequest($data, $expectedErrors);
    }

    public function testMissingLastName(): void
    {
        $data           = [
            'first_name'            => 'John',
            'email'                 => 'test@example.com',
            'password'              => 'secret123',
            'password_confirmation' => 'secret123',
            'phone'                 => '+1234567890',
        ];
        $expectedErrors = ['last_name' => ['Last name is required.']];
        $this->validateRequest($data, $expectedErrors);
    }

    public function testInvalidEmail(): void
    {
        $data           = [
            'first_name'            => 'John',
            'last_name'             => 'Doe',
            'email'                 => 'not-an-email',
            'password'              => 'secret123',
            'password_confirmation' => 'secret123',
            'phone'                 => '+1234567890',
        ];
        $expectedErrors = ['email' => ['Please provide a valid email address.']];
        $this->validateRequest($data, $expectedErrors);
    }

    public function testPasswordMismatch(): void
    {
        $data           = [
            'first_name'            => 'John',
            'last_name'             => 'Doe',
            'email'                 => 'test@example.com',
            'password'              => 'secret123',
            'password_confirmation' => 'different123',
            'phone'                 => '+1234567890',
        ];
        $expectedErrors = ['password' => ['Password confirmation does not match.']];
        $this->validateRequest($data, $expectedErrors);
    }

    public function testMissingPhone(): void
    {
        $data           = [
            'first_name'            => 'John',
            'last_name'             => 'Doe',
            'email'                 => 'test@example.com',
            'password'              => 'secret123',
            'password_confirmation' => 'secret123',
        ];
        $expectedErrors = ['phone' => ['Phone number is required.']];
        $this->validateRequest($data, $expectedErrors);
    }

    public function testMaxLengthViolations(): void
    {
        $data           = [
            'first_name'            => str_repeat('a', 256),
            'last_name'             => str_repeat('b', 256),
            'email'                 => str_repeat('c', 256) . '@example.com',
            'password'              => 'secret123',
            'password_confirmation' => 'secret123',
            'phone'                 => str_repeat('1', 21),
        ];
        $expectedErrors = [
            'first_name' => ['First name cannot exceed 255 characters.'],
            'last_name'  => ['Last name cannot exceed 255 characters.'],
            'email'      => ['Email cannot exceed 255 characters.'],
            'phone'      => ['Phone number cannot exceed 20 characters.'],
        ];
        $this->validateRequest($data, $expectedErrors);
    }

    public function testMissingRequiredFields(): void
    {
        $data           = [];
        $expectedErrors = [
            'first_name' => ['First name is required.'],
            'last_name'  => ['Last name is required.'],
            'email'      => ['Email address is required.'],
            'password'   => ['Password is required.'],
            'phone'      => ['Phone number is required.'],
        ];
        $this->validateRequest($data, $expectedErrors);
    }
}
