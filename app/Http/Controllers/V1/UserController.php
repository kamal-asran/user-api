<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\GetUsersRequest;
use App\Services\V1\DataProviderXService;
use App\Services\V1\DataProviderYService;
use App\Services\V1\UserService;

class UserController extends Controller
{
    public function index(GetUsersRequest $request)
    {

        $dataProviderXService = new DataProviderXService();
        $dataProviderYService = new DataProviderYService();

        $userService = new UserService([$dataProviderXService, $dataProviderYService]);

        $users = $userService->getUsers();

        // Apply filters based on the request data
        $filteredUsers = $this->applyFilters($users, $request);

        return response()->json([
            'data' => $users,
        ]);
    }
    public function applyFilters($data, $request)
    {
        if ($request->has('provider')) {
            $users = array_filter($data, function ($item) use ($request) {
                return isset($item['provider']) && $item['provider'] === $request->input('provider');
            });
        }

        if ($request->has('statusCode')) {
            $users = array_filter($data, function ($item) use ($request) {
                return isset($item['statusCode']) && $item['statusCode']===$request->input('statusCode');
            });
        }

        if ($request->has('balanceMin')) {
            $users = array_filter($data, function ($item) use ($request) {
                return isset($item['balanceMin']) && $item['balanceMin'] >= $request->input('balanceMin');
            });
        }

        if ($request->has('balanceMax')) {
            $users = array_filter($data, function ($item) use ($request) {
                return isset($item['balanceMax']) && $item['balanceMax'] <= $request->input('balanceMax');
            });
        }

        if ($request->has('currency')) {
            $users = array_filter($data, function ($item) use ($request) {
                return isset($item['currency']) && $item['currency']  === $request->input('currency');
            });
        }

        return $users;
    }



}