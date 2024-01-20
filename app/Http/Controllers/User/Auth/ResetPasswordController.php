<?php

namespace App\Http\Controllers\Provider\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Provider\Auth\CheckResetPasswordRequest;
use App\Http\Requests\Provider\Auth\EditPasswordRequest;
use App\Http\Requests\Provider\Auth\ResetPasswordRequest;
use App\Repositories\Contracts\IServiceProvider;
use App\Repositories\Contracts\IUser;
use App\Repositories\Eloquent\Criteria\Where;
use App\Services\OtpService;


class   ResetPasswordController extends Controller
{
    private $provider,$otpService;

    public function __construct(IServiceProvider $provider, OtpService $otpService)
    {
        $this->provider = $provider;
        $this->otpService = $otpService;
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        $provider = $this->provider->withCriteria(new Where('phone', $request->phone))->first();
        //TODO: Change this when OTP service is active
        $verification_code = 1111;
        $this->provider->forceFill($provider, ['verification_code' => $verification_code]);
        $this->otpService->sendOtp($provider);
        return self::success(trans('messages.verified_code_sent'));
    }

    public function checkCode(CheckResetPasswordRequest $request)//: \Illuminate\Http\Response
    {
        $provider = $this->provider->withCriteria(new Where('phone', $request->phone))->firstOrFail();
        if ($provider->verification_code != $request->code) {
            return self::failure(trans('messages.wrong_code'), 400);
        }
        return self::success('The verification code is correct!');
    }

    public function editPassword(EditPasswordRequest $request): \Illuminate\Http\Response
    {
        $provider = $this->provider->withCriteria(new Where('phone', $request->phone))->firstOrFail();
        if ($provider->verification_code != $request->code) {
            return self::failure(trans('messages.wrong_code'), 400);
        }
        $this->provider->forceFill($provider, ['password' => $request->new_password]);
        return self::success('password changed successfully!');
    }

}
