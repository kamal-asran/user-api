<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\GetUsersRequest;
use App\Services\V1\UserService;

class UserController extends Controller
{
    public function index(GetUsersRequest $request, UserService $userService)
    {
        // Get the validated request data
        $requestData = $request->validated();

        // Fetch users from the service layer based on the filters
        $users = $userService->getUsers($requestData);

        // Return the filtered users
        return response()->json($users);
    }


}