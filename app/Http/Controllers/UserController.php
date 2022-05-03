<?php

namespace App\Http\Controllers;

use App\Models\RankedUser;
use App\Services\Contracts\UserServiceContract;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserServiceContract $userService)
    {
        $this->userService = $userService;
    }
    public function overallUser(RankedUser $user)
    {
        $numberOfRecord = request()->input('numberOfRecord') ? request()->input('numberOfRecord') : 5;
        $all = $this->userService->overallUserPosition($user,$numberOfRecord);
        return view('welcome')->with(compact('all'));
    }
}
