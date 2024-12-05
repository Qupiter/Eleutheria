<?php

namespace Tests\Http\Response;

use App\Http\Response\Success;
use Illuminate\Foundation\Testing\TestCase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;

class SuccessTest extends TestCase
{
    public function testSuccessResponseWithBasicData(): void
    {
        $response = Success::make('Operation completed', ['key' => 'value']);

        $expected = [
            'status'  => 'success',
            'message' => 'Operation completed',
            'data'    => ['key' => 'value'],
            'meta'    => [
                'code'      => 200,
                'timestamp' => now()->toIso8601String(),
            ],
        ];

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals($expected, $response->getData(true));
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testSuccessResponseWithJsonResource(): void
    {
        $resource = new class(['name' => 'Test User']) extends JsonResource {
            public function toArray($request): array
            {
                return [
                    'name' => $this->resource['name'],
                ];
            }
        };

        $response = Success::make('Resource returned successfully', $resource);

        $expected = [
            'status'  => 'success',
            'message' => 'Resource returned successfully',
            'data'    => ['name' => 'Test User'],
            'meta'    => [
                'code'      => 200,
                'timestamp' => now()->toIso8601String(),
            ],
        ];

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals($expected, $response->getData(true));
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testSuccessResponseWithEmptyData(): void
    {
        $response = Success::make();

        $expected = [
            'status'  => 'success',
            'message' => 'Success',
            'data'    => [],
            'meta'    => [
                'code'      => 200,
                'timestamp' => now()->toIso8601String(),
            ],
        ];

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals($expected, $response->getData(true));
        $this->assertEquals(200, $response->getStatusCode());
    }
}
