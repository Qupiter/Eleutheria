<?php

namespace Tests\Http\Resources;

use App\Http\Resources\UserResource;
use App\Models\Account\User;
use App\Models\Account\UserRole;
use Illuminate\Foundation\Testing\TestCase;
use Tests\Mocks\UserMocks;

class UserResourceTest extends TestCase
{
    use UserMocks;

    public function testUserResourceStructure(): void
    {
        $user = $this->mockUserWithRole(UserRole::VOTER);

        $user->first_name = 'John';
        $user->last_name  = 'Doe';
        $user->email      = 'johndoe@example.com';
        $user->phone      = '+1234567890';

        $resource = new UserResource($user);
        $result   = $resource->toArray(request());

        $expected = [
            'id'         => 1,
            'first_name' => 'John',
            'last_name'  => 'Doe',
            'email'      => 'johndoe@example.com',
            'phone'      => '+1234567890',
        ];

        $this->assertEquals($expected, $result);
    }

    public function testUserResourceWithNullableFields(): void
    {
        $user = $this->mockUserWithRole(UserRole::VOTER, 2);

        $user->first_name = 'Jane';
        $user->last_name  = 'Smith';
        $user->email      = 'janesmith@example.com';
        $user->phone      = null;

        $resource = new UserResource($user);
        $result   = $resource->toArray(request());

        $expected = [
            'id'         => 2,
            'first_name' => 'Jane',
            'last_name'  => 'Smith',
            'email'      => 'janesmith@example.com',
            'phone'      => null,
        ];

        $this->assertEquals($expected, $result);
    }
}
