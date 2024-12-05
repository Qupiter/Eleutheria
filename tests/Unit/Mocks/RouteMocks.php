<?php

namespace Tests\Mocks;

use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Mockery;

trait RouteMocks
{
    /**
     * Mock route parameters for the request.
     */
    protected function mockRouteParameter(string $key, $value, Request $request = null): void
    {
        if($request === null) $request = new Request();

        $mockRoute = Mockery::mock(Route::class);

        $mockRoute->shouldReceive('parameter')
            ->with($key, Mockery::any())
            ->andReturn($value);

        $request->setRouteResolver(function () use ($mockRoute) {
            return $mockRoute;
        });
    }
}
