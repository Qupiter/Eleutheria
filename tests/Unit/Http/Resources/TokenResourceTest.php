<?php

namespace Tests\Http\Resources;

use App\Http\Resources\TokenResource;
use Illuminate\Foundation\Testing\TestCase;
use Illuminate\Support\Str;

class TokenResourceTest extends TestCase
{
    public function testTokenResourceStructure(): void
    {
        // Mock a token with a plainTextToken
        $token = (object) [
            'plainTextToken' => Str::random(64),
        ];

        $resource = new TokenResource($token);
        $result = $resource->toArray(request());

        $expected = [
            'token' => $token->plainTextToken,
        ];

        $this->assertEquals($expected, $result);
    }

    public function testTokenResourceHandlesMissingToken(): void
    {
        $token = (object) [
            'plainTextToken' => null,
        ];

        $resource = new TokenResource($token);
        $result = $resource->toArray(request());

        $expected = [
            'token' => null,
        ];

        $this->assertEquals($expected, $result);
    }
}
