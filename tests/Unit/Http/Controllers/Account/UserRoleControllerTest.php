<?php

namespace Http\Controllers\Account;

use App\Exceptions\Service\UserService\UserAlreadyHasThisRoleException;
use App\Http\Controllers\Account\UserRoleController;
use App\Http\Requests\Account\UserRoleRequest;
use App\Models\Account\User;
use App\Services\UserRoleService;
use App\Services\UserService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Mockery;
use Illuminate\Foundation\Testing\TestCase;

class UserRoleControllerTest extends TestCase
{
    private Mockery\MockInterface $userService;
    private Mockery\MockInterface $userRoleService;
    private UserRoleController $userRoleController;

    protected function setUp(): void
    {
        parent::setUp();

        // Mock services
        $this->userService     = Mockery::mock(UserService::class);
        $this->userRoleService = Mockery::mock(UserRoleService::class);

        // Instantiate the controller
        $this->userRoleController = new UserRoleController(
            $this->userService,
            $this->userRoleService
        );
    }

    public function test_index_returns_current_user_roles()
    {
        $mockUser  = Mockery::mock(User::class);
        $mockRoles = Collection::make(['Admin', 'Editor']);
        $mockUser->shouldReceive('getRoleNames')
            ->once()
            ->andReturn($mockRoles);

        Auth::shouldReceive('user')
            ->once()
            ->andReturn($mockUser);

        $response = $this->userRoleController->index();

        $this->assertInstanceOf(JsonResponse::class, $response);
        $responseData = $response->getData(true);
        $this->assertEquals('User roles:', $responseData['message']);
        $this->assertEquals($mockRoles->all(), $responseData['data']);
    }

    public function test_index_returns_specific_user_roles()
    {
        $mockUser  = Mockery::mock(User::class);
        $mockRoles = Collection::make(['Viewer']);
        $mockUser->shouldReceive('getRoleNames')
            ->once()
            ->andReturn($mockRoles);

        $this->userService->shouldReceive('getUserById')
            ->once()
            ->with(1)
            ->andReturn($mockUser);

        $response = $this->userRoleController->index(1);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $responseData = $response->getData(true);
        $this->assertEquals('User roles:', $responseData['message']);
        $this->assertEquals($mockRoles->all(), $responseData['data']);
    }

    public function test_assign_role_to_user()
    {
        $userData = [
            'userId'   => 1,
            'roleName' => 'Admin',
        ];

        $mockUser  = Mockery::mock(User::class);
        $mockRoles = Collection::make(['Admin']);
        $mockUser->shouldReceive('getRoleNames')
            ->once()
            ->andReturn($mockRoles);

        $mockRequest = Mockery::mock(UserRoleRequest::class);
        $mockRequest->shouldReceive('validated')
            ->once()
            ->andReturn($userData);

        $this->userRoleService->shouldReceive('assign')
            ->once()
            ->with(1, 'Admin')
            ->andReturn($mockUser);

        $response = $this->userRoleController->assign($mockRequest);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $responseData = $response->getData(true);
        $this->assertEquals('User roles:', $responseData['message']);
        $this->assertEquals($mockRoles->all(), $responseData['data']);
    }

    public function test_assign_role_throws_exception_if_already_assigned()
    {
        $this->expectException(UserAlreadyHasThisRoleException::class);

        $userData = [
            'userId'   => 1,
            'roleName' => 'Admin',
        ];

        $mockRequest = Mockery::mock(UserRoleRequest::class);
        $mockRequest->shouldReceive('validated')
            ->once()
            ->andReturn($userData);

        $this->userRoleService->shouldReceive('assign')
            ->once()
            ->with(1, 'Admin')
            ->andThrow(UserAlreadyHasThisRoleException::class);

        $this->userRoleController->assign($mockRequest);
    }

    public function test_remove_role_from_user()
    {
        $userData = [
            'userId'   => 1,
            'roleName' => 'Admin',
        ];

        $mockUser  = Mockery::mock(User::class);
        $mockRoles = Collection::make([]);
        $mockUser->shouldReceive('getRoleNames')
            ->once()
            ->andReturn($mockRoles);

        $mockRequest = Mockery::mock(UserRoleRequest::class);
        $mockRequest->shouldReceive('validated')
            ->once()
            ->andReturn($userData);

        $this->userRoleService->shouldReceive('remove')
            ->once()
            ->with(1, 'Admin')
            ->andReturn($mockUser);

        $response = $this->userRoleController->remove($mockRequest);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $responseData = $response->getData(true);
        $this->assertEquals('User roles:', $responseData['message']);
        $this->assertEquals($mockRoles->all(), $responseData['data']);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
