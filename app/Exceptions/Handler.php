<?php

namespace App\Exceptions;

use App\Exceptions\General\AuthenticationException;
use App\Exceptions\General\AuthorizationException;
use App\Exceptions\General\InternalServerErrorException;
use App\Exceptions\General\MethodNotAllowedHttpException;
use App\Exceptions\General\ModelNotFoundException;
use App\Exceptions\General\NotFoundHttpException;
use App\Exceptions\General\QueryException;
use App\Exceptions\General\RoleAuthorizationException;
use App\Exceptions\General\RoleDoesNotExistException;
use App\Exceptions\General\ThrottleRequestsException;
use App\Exceptions\General\ValidationException;
use App\Http\Response\Failure;
use Illuminate\Auth\Access\AuthorizationException as BaseAuthorizationException;
use Illuminate\Auth\AuthenticationException as BaseAuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException as BaseModelNotFoundException;
use Illuminate\Database\QueryException as BaseQueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\ThrottleRequestsException as BaseThrottleRequestsException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException as BaseValidationException;
use Spatie\Permission\Exceptions\RoleDoesNotExist;
use Spatie\Permission\Exceptions\UnauthorizedException as BaseUnauthorizedException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException as BaseMethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException as BaseNotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * @param $request
     * @param Throwable $e
     * @return JsonResponse|Response
     * @throws Throwable
     */
    public function render($request, Throwable $e): JsonResponse|Response
    {
        if ($request->expectsJson()) {
            $customException = $this->handleExceptions($e);

            return Failure::make($customException);
        }

        return parent::render($request, $e);
    }

    /**
     * Maps general laravel exceptions to custom exceptions
     *
     * @param Throwable $e
     * @return BaseApiException
     */
    private function handleExceptions(Throwable $e): BaseApiException
    {
        // Exception customization
        $exception = match ($e::class) {
            BaseNotFoundHttpException::class         => new NotFoundHttpException(),
            BaseMethodNotAllowedHttpException::class => new MethodNotAllowedHttpException(),
            BaseAuthenticationException::class       => new AuthenticationException(),
            BaseAuthorizationException::class        => new AuthorizationException(),
            BaseUnauthorizedException::class         => new RoleAuthorizationException(),
            BaseValidationException::class           => new ValidationException($e->errors()),
            BaseThrottleRequestsException::class     => new ThrottleRequestsException(),
            BaseQueryException::class                => new QueryException(),
            RoleDoesNotExist::class                  => new RoleDoesNotExistException(),
            default                                  => new InternalServerErrorException(),
        };

        if ($e->getPrevious() instanceof BaseModelNotFoundException) {
            $exception = new ModelNotFoundException();
        }

        return $exception;
    }
}
