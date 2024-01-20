<?php

namespace App\Http\Controllers\Provider\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    public function logout(Request $request): \Illuminate\Http\Response
    {
        $all_devices = $request->query('all_devices');
        $provider = auth('provider')->user();
        if ($all_devices == true) {
            $provider->tokens()->delete();
            return self::success(trans('messages.logged_out_all'));
        }
        $provider->currentAccessToken()->delete();
        return self::success(trans('messages.logged_out'));
    }
}
