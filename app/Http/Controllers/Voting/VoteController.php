<?php

namespace App\Http\Controllers\Voting;

use App\Http\Controllers\Controller;
use App\Http\Response\Success;
use Illuminate\Http\JsonResponse;

class VoteController extends Controller
{
    public function vote(): JsonResponse
    {
        return Success::make('You voted successfully!');
    }
}
