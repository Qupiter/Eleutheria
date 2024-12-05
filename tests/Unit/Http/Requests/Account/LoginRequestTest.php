<?php

namespace Tests\Http\Requests\Account;

use App\Http\Requests\Account\LoginRequest;
use Tests\Http\Requests\RequestTest;

class LoginRequestTest extends RequestTest
{
    public function setUp():void
    {
        parent::setUp();
        $this->request = new LoginRequest();
    }

    public function testAuthorize(): void
    {
        $this->assertTrue($this->request->authorize());
    }

    public function testSuccess(): void
    {
        $data = ['email' => 'test@example.com', 'password' => 'secret123'];
        $this->validateRequest($data, []);
    }

    public function testMissingEmail(): void
    {
        $data           = ['password' => 'secret123'];
        $expectedErrors = ['email' => ['Email is required.']];
        $this->validateRequest($data, $expectedErrors);
    }

    public function testInvalidEmail(): void
    {
        $data           = ['email' => 'not-an-email', 'password' => 'secret123'];
        $expectedErrors = ['email' => ['Please provide a valid email address.']];
        $this->validateRequest($data, $expectedErrors);
    }

    public function testMissingPassword(): void
    {
        $data           = ['email' => 'test@example.com'];
        $expectedErrors = ['password' => ['Password is required.']];
        $this->validateRequest($data, $expectedErrors);
    }

    public function testMissingBothFields(): void
    {
        $data           = [];
        $expectedErrors = [
            'email'    => ['Email is required.'],
            'password' => ['Password is required.'],
        ];
        $this->validateRequest($data, $expectedErrors);
    }

    public function testEmptyEmail(): void
    {
        $data           = ['email' => '', 'password' => 'secret123'];
        $expectedErrors = ['email' => ['Email is required.']];
        $this->validateRequest($data, $expectedErrors);
    }

    public function testEmptyPassword(): void
    {
        $data           = ['email' => 'test@example.com', 'password' => ''];
        $expectedErrors = ['password' => ['Password is required.']];
        $this->validateRequest($data, $expectedErrors);
    }
}
