<?php

namespace Http\Controllers\Account;

use App\Http\Controllers\Account\UserController;
use App\Http\Requests\Account\StoreUserRequest;
use App\Http\Requests\Account\UpdateUserRequest;
use App\Models\Account\User;
use App\Services\UserService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\TestCase;
use Illuminate\Http\JsonResponse;
use Mockery;

class UserControllerTest extends TestCase
{
    private Mockery\MockInterface $userService;
    private UserController $userController;

    protected function setUp(): void
    {
        parent::setUp();

        $this->userService = Mockery::mock(UserService::class);
        $this->userController = new UserController($this->userService);
    }

    public function test_index_returns_list_of_users()
    {
        $user  = new User($this->getUserData());
        $collection = new Collection([$user]);
        $this->userService->shouldReceive('getAllUsers')
            ->once()
            ->andReturn($collection);

        $response = $this->userController->index();

        $this->assertInstanceOf(JsonResponse::class, $response);
        $responseData = $response->getData(true);
        $this->assertEquals('Users list:', $responseData['message']);
    }

    public function test_store_creates_new_user()
    {
        $userData = $this->getUserData();
        $newUser = new User($userData);

        $mockRequest = Mockery::mock(StoreUserRequest::class);
        $mockRequest->shouldReceive('validated')
            ->once()
            ->andReturn($userData);

        $this->userService->shouldReceive('createUser')
            ->once()
            ->with($userData)
            ->andReturn($newUser);

        $response = $this->userController->store($mockRequest);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $responseData = $response->getData(true);
        $this->assertEquals('User created successfully.', $responseData['message']);
    }

    public function test_show_returns_user_details()
    {
        $userData = $this->getUserData();
        $newUser = new User($userData);

        $this->userService->shouldReceive('getUserById')
            ->once()
            ->with(1)
            ->andReturn($newUser);

        $response = $this->userController->show(1);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $responseData = $response->getData(true);
        $this->assertEquals('User is:', $responseData['message']);
    }

    public function test_update_modifies_user()
    {
        $userData = $this->getUserData();
        $newUser = new User($userData);

        $mockRequest = Mockery::mock(UpdateUserRequest::class);
        $mockRequest->shouldReceive('validated')
            ->once()
            ->andReturn($userData);

        $this->userService->shouldReceive('updateUser')
            ->once()
            ->with(1, $userData)
            ->andReturn($newUser);

        $response = $this->userController->update($mockRequest, 1);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $responseData = $response->getData(true);
        $this->assertEquals('User updated successfully.', $responseData['message']);
    }

    public function test_discard_soft_deletes_user()
    {
        $userData = $this->getUserData();
        $newUser = new User($userData);

        $this->userService->shouldReceive('softDeleteUser')
            ->once()
            ->with(1)
            ->andReturn($newUser);

        $response = $this->userController->discard(1);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $responseData = $response->getData(true);
        $this->assertEquals('User deactivated successfully.', $responseData['message']);
    }

    public function test_destroy_hard_deletes_user()
    {
        $this->userService->shouldReceive('hardDeleteUser')
            ->once()
            ->with(1);

        $response = $this->userController->destroy(1);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $responseData = $response->getData(true);
        $this->assertEquals('User deleted successfully.', $responseData['message']);
    }

    private function getUserData(): array
    {
        return [
            'first_name' => 'John',
            'last_name'  => 'Doe',
            'email'      => 'john.doe@example.com',
            'password'   => 'securepassword',
            'phone'      => '1234567891',
        ];
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
