<?php

namespace Tests\Http\Requests;

use Illuminate\Foundation\Testing\TestCase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tests\Mocks\RouteMocks;
use Tests\Mocks\UserMocks;

abstract class RequestTest extends TestCase
{
    use UserMocks, RouteMocks;

    protected Request $request;

    /**
     * Perform the validation for the given data and expected errors.
     */
    protected function validateRequest(array $data, array $expectedErrors): void
    {
        $validator = Validator::make($data, $this->request->rules(), $this->request->messages());
        $isValid   = $validator->passes();
        $errors    = $validator->errors()->toArray();

        if (empty($expectedErrors)) {
            $this->assertTrue($isValid);
            $this->assertEmpty($errors);
        } else {
            $this->assertFalse($isValid);
            $this->assertEquals($expectedErrors, $errors);
        }
    }
}
