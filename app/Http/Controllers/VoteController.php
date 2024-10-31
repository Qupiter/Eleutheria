<?php

namespace App\Http\Controllers;

use App\Http\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class VoteController extends Controller
{
    use ApiResponseTrait;

    public function vote(): JsonResponse
    {
        $user = Auth::user();
        $response = $this->errorResponse(new \Exception('user is not a voter'), 400);

        if ($user->hasRole('voter')) {
            $response = $this->successResponse('user is a voter');
        }

        return $response;
    }
}
