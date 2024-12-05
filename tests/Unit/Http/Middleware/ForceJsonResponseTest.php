<?php

namespace Tests\Http\Middleware;

use App\Http\Middleware\ForceJsonResponse;
use Illuminate\Http\Request;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Response;

class ForceJsonResponseTest extends TestCase
{
    public function testMiddlewareSetsAcceptHeaderToApplicationJson(): void
    {
        $request = new Request();

        $next = fn ($req) => new Response();

        $middleware = new ForceJsonResponse();

        $response = $middleware->handle($request, $next);

        $this->assertEquals('application/json', $request->headers->get('Accept'));

        $this->assertInstanceOf(Response::class, $response);
    }
}
