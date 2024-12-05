<?php

namespace Tests\Http\Requests\Account;

use App\Http\Requests\Account\UpdateUserRequest;
use App\Models\Account\UserRole;
use Illuminate\Support\Facades\Auth;
use Tests\Http\Requests\RequestTest;

class UpdateUserRequestTest extends RequestTest
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->request = new UpdateUserRequest();
    }

    /**
     * Test authorization for the request.
     */
    public function testAuthorizationAsAdmin(): void
    {
        $adminUser = $this->mockUserWithRole(UserRole::ADMIN);

        Auth::shouldReceive('check')->andReturn(true);
        Auth::shouldReceive('user')->andReturn($adminUser);

        $this->assertTrue($this->request->authorize());
    }

    public function testAuthorizationAsOwner(): void
    {
        $ownerUser = $this->mockUserWithRole(UserRole::VOTER);

        Auth::shouldReceive('check')->andReturn(true);
        Auth::shouldReceive('user')->andReturn($ownerUser);

        $this->mockRouteParameter('id', 1, $this->request);

        $this->assertTrue($this->request->authorize());
    }

    public function testAuthorizationFailsForOtherUsers(): void
    {
        $nonAuthorizedUser = $this->mockUserWithRole(UserRole::VOTER, 2);

        Auth::shouldReceive('check')->andReturn(true);
        Auth::shouldReceive('user')->andReturn($nonAuthorizedUser);

        $this->mockRouteParameter('id', 1, $this->request);

        $this->assertFalse($this->request->authorize());
    }

    /**
     * Validation tests
     */
    public function testValidData(): void
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

    public function testInvalidEmail(): void
    {
        $data = ['email' => 'not-an-email'];

        $this->validateRequest($data, [
            'email' => ['The email field must be a valid email address.'],
        ]);
    }

    public function testInvalidPassword(): void
    {
        $data = ['password' => 'short'];

        $this->validateRequest($data, [
            'password' => ['The password field must be at least 8 characters.'],
        ]);
    }

    public function testOptionalFields(): void
    {
        $data = []; // No fields provided

        $this->validateRequest($data, []); // Should pass, as all fields are nullable or optional
    }
}
