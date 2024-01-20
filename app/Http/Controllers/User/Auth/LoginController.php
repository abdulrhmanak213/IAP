<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\Auth\LoginRequest;
use App\Http\Resources\User\Auth\LoginResource;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    public function login(LoginRequest $request): \Illuminate\Http\Response
    {
        $credentials = $request->validated();
        if (!Auth::guard()->attempt($credentials)) {
            return self::failure('wrong credentials', 400);
        }
        $user = Auth::guard()->user();
        $user['access_token'] = $user->createToken('user_token')->plainTextToken;
        return self::returnData('user', LoginResource::make($user));
    }
}
