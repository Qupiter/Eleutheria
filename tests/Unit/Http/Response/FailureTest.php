<?php

namespace Tests\Http\Response;

use App\Exceptions\BaseApiException;
use App\Exceptions\General\QueryException;
use App\Exceptions\General\ValidationException;
use App\Http\Response\Failure;
use Illuminate\Foundation\Testing\TestCase;
use Illuminate\Http\JsonResponse;
use Mockery;

class FailureTest extends TestCase
{
    public function testFailureResponse(): void
    {
        $exceptioon = new QueryException();

        $response = Failure::make($exceptioon);

        $expected = [
            'status'  => 'fail',
            'message' => $exceptioon->getMessage(),
            'uuid'    => $exceptioon->getUuid(),
            'errors'  => [],
            'meta'    => [
                'code'      => $exceptioon->getCode(),
                'timestamp' => now()->toIso8601String(),
            ],
        ];

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals($expected, $response->getData(true));
        $this->assertEquals($exceptioon->getCode(), $response->getStatusCode());
    }

    public function testFailureResponseWithException(): void
    {
        $exception = new ValidationException(['field' => 'error']);

        $response = Failure::make($exception);

        $expected = [
            'status'  => 'fail',
            'message' => $exception->getMessage(),
            'uuid'    => $exception->getUuid(),
            'errors'  => $exception->getErrors(),
            'meta'    => [
                'code'      => $exception->getCode(),
                'timestamp' => now()->toIso8601String(),
            ],
        ];

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals($expected, $response->getData(true));
        $this->assertEquals($exception->getCode(), $response->getStatusCode());
    }
}
