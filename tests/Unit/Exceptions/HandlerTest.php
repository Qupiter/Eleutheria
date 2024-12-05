<?php

namespace Tests\Exceptions;

use App\Exceptions\General\AuthenticationException;
use App\Exceptions\General\AuthorizationException;
use App\Exceptions\General\InternalServerErrorException;
use App\Exceptions\General\MethodNotAllowedHttpException;
use App\Exceptions\General\ModelNotFoundException;
use App\Exceptions\General\QueryException;
use App\Exceptions\General\RoleAuthorizationException;
use App\Exceptions\General\ThrottleRequestsException;
use App\Exceptions\General\ValidationException as CustomValidationException;
use App\Exceptions\Handler;
use App\Exceptions\Service\UserService\RoleDoesNotExistException;
use Exception;
use Illuminate\Auth\AuthenticationException as BaseAuthenticationException;
use Illuminate\Auth\Access\AuthorizationException as BaseAuthorizationException;
use Illuminate\Database\QueryException as BaseQueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException as BaseModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException as BaseValidationException;
use PHPUnit\Framework\Attributes\DataProvider;
use Spatie\Permission\Exceptions\UnauthorizedException as BaseUnauthorizedException;
use Spatie\Permission\Exceptions\RoleDoesNotExist;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException as BaseMethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException as BaseNotFoundHttpException;
use Illuminate\Http\Exceptions\ThrottleRequestsException as BaseThrottleRequestsException;
use Tests\TestCase;
use Throwable;

class HandlerTest extends TestCase
{
    public static function exceptionProvider(): array
    {
        return [
            [BaseNotFoundHttpException::class, ModelNotFoundException::class],
            [BaseMethodNotAllowedHttpException::class, MethodNotAllowedHttpException::class],
            [BaseAuthenticationException::class, AuthenticationException::class],
            [BaseAuthorizationException::class, AuthorizationException::class],
            [BaseUnauthorizedException::class, RoleAuthorizationException::class],
            [BaseValidationException::class, CustomValidationException::class],
            [BaseThrottleRequestsException::class, ThrottleRequestsException::class],
            [BaseQueryException::class, QueryException::class],
            [RoleDoesNotExist::class, RoleDoesNotExistException::class],
            [Exception::class, InternalServerErrorException::class],
        ];
    }

    #[DataProvider('exceptionProvider')]
    public function testHandleExceptionsMapsToCustomExceptions(string $baseException, string $customException): void
    {
        $baseExceptionInstance = $this->createBaseExceptionInstance($baseException);

        $handler = app(Handler::class);

        $result = $this->invokePrivateMethod($handler, 'handleExceptions', [$baseExceptionInstance]);

        $this->assertInstanceOf($customException, $result);
    }

    public function testHandlerReturnsJsonResponseForApiRequests(): void
    {
        $exception = new BaseNotFoundHttpException('Endpoint not found', null);
        $handler = app(Handler::class);

        // Properly mock the request
        $request = $this->getMockBuilder(Request::class)
            ->onlyMethods(['expectsJson'])
            ->getMock();

        $request->expects($this->once())
            ->method('expectsJson')
            ->willReturn(true);

        $response = $handler->render($request, $exception);

        $this->assertInstanceOf(JsonResponse::class, $response);

        $data = $response->getData(true);
        $this->assertEquals('fail', $data['status']);
        $this->assertEquals('Endpoint not found', $data['message']);
    }

    private function createBaseExceptionInstance(string $exceptionClass): Throwable
    {
        return match ($exceptionClass) {
            BaseNotFoundHttpException::class => new $exceptionClass('Not Found', new BaseModelNotFoundException('model')),
            BaseMethodNotAllowedHttpException::class => new $exceptionClass(['GET', 'POST']), // Allowed methods
            BaseAuthenticationException::class => new $exceptionClass('Unauthenticated', ['web']),
            BaseAuthorizationException::class => new $exceptionClass('Forbidden'),
            BaseUnauthorizedException::class => new $exceptionClass(403, 'Unauthorized'),
            BaseValidationException::class => new $exceptionClass(
                Validator::make([], ['field' => 'required'])
            ),
            BaseThrottleRequestsException::class => new $exceptionClass(
                'Too many requests, please try again later.', null, ['Retry-After' => 60], 429
            ),
            BaseQueryException::class => new $exceptionClass(
                'testName', 'SELECT * FROM users', [], new Exception('SQL error')
            ),
            BaseModelNotFoundException::class => new $exceptionClass(), // Model not found
            default => new $exceptionClass('Default Message', 500), // Default constructor
        };
    }

    private function invokePrivateMethod(object $object, string $methodName, array $parameters = [])
    {
        $reflection = new \ReflectionClass($object);
        $method = $reflection->getMethod($methodName);

        return $method->invokeArgs($object, $parameters);
    }
}
