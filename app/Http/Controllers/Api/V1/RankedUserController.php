<?php

namespace App\Http\Controllers\Api\V1;


use App\Models\RankedUser;
use App\Services\Contracts\UserServiceContract;
use Illuminate\Http\Request;
use Illuminate\Http\Response;


class RankedUserController extends Controller
{

    protected $userService;

    public function __construct(UserServiceContract $userService)
    {
        $this->userService = $userService;
    }

    public function overallPosition(RankedUser $user)
    {
        $numberOfRecord = request()->input('numberOfRecord') ? request()->input('numberOfRecord') : 5;

        return response()->json($this->userService->overallUserPosition($user, $numberOfRecord), Response::HTTP_OK);
    }
}
