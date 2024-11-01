<?php

namespace App\Http\Controllers\Voting;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class VoteController extends Controller
{
    public function vote(): JsonResponse
    {
        return $this->successResponse('You voted successfully!');
    }
}
