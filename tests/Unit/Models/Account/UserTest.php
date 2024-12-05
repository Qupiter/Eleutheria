<?php

namespace Tests\Models\Account;

use App\Models\Account\User;
use App\Models\Account\UserRole;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;
use Tests\Mocks\UserMocks;

class UserTest extends TestCase
{
    use UserMocks, RefreshDatabase;

    /**
     * Test that the User model uses the correct traits.
     */
    public function testUserModelUsesTraits(): void
    {
        $traits = class_uses(User::class);

        $this->assertContains(HasApiTokens::class, $traits);
        $this->assertContains(Notifiable::class, $traits);
        $this->assertContains(HasRoles::class, $traits);
        $this->assertContains(HasFactory::class, $traits);
        $this->assertContains(SoftDeletes::class, $traits);
    }

    /**
     * Test that a User can be created and retrieved.
     */
    public function testUserCanBeCreated(): void
    {
        $user = User::factory()->create([
            'first_name' => 'John',
            'last_name'  => 'Doe',
            'email'      => 'johndoe@example.com',
            'password'   => 'password123',
            'phone'      => '+1234567890',
        ]);

        $this->assertDatabaseHas('users', [
            'first_name' => 'John',
            'last_name'  => 'Doe',
            'email'      => 'johndoe@example.com',
        ]);

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals('John', $user->first_name);
        $this->assertEquals('Doe', $user->last_name);
    }

    /**
     * Test that the User model supports roles.
     */
    public function testUserHasRoles(): void
    {
        $user = User::factory()->create();
        $role = Role::create(['name' => UserRole::ADMIN->value]);

        $user->assignRole(UserRole::ADMIN->value);

        $this->assertTrue($user->hasRole(UserRole::ADMIN->value));
    }

    /**
     * Test that the User model hides sensitive attributes.
     */
    public function testUserHidesSensitiveAttributes(): void
    {
        $user = $this->mockUserWithRole(UserRole::VOTER);

        $user->password = 'secret';
        $user->remember_token = 'token';

        $userArray = $user->toArray();

        $this->assertArrayNotHasKey('password', $userArray);
        $this->assertArrayNotHasKey('remember_token', $userArray);
    }

    public function testUserSupportsSoftDeletes(): void
    {
        $user = User::factory()->create();
        $user->delete();

        $this->assertSoftDeleted($user);
    }

    public function testUserCastsAttributes(): void
    {
        $user = $this->mockUserWithRole(UserRole::VOTER);
        $user->email_verified_at = now();

        $this->assertInstanceOf(Carbon::class, $user->email_verified_at);
    }
}
