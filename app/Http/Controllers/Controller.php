<?php

namespace App\Http\Controllers;

use App\Http\Traits\ApiResponseTrait;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

abstract class Controller extends BaseController
{
    use AuthorizesRequests;
    use ValidatesRequests;

    //TODO:: this response trait is probably not needed
    // think more about exception handling
    use ApiResponseTrait;
}
