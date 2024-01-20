<?php

namespace App\Http\Controllers\Provider\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Provider\Auth\ResendCodeRequest;
use App\Http\Requests\Provider\Auth\VerifyAccountRequest;
use App\Repositories\Contracts\IServiceProvider;
use App\Repositories\Eloquent\Criteria\Where;
use App\Services\OtpService;
use Illuminate\Http\Request;

class VerifyAccountController extends Controller
{
    private $provider, $otpService;

    public function __construct(IServiceProvider $provider, OtpService $otpService)
    {
        $this->provider = $provider;
        $this->otpService = $otpService;
    }

    public function resendCode(ResendCodeRequest $request): \Illuminate\Http\Response
    {
        $provider = $this->provider->withCriteria(new Where('phone', $request->phone))->firstOrFail();
        //TODO: Change this when OTP service is active
        $verification_code = 1111;
        $this->provider->forcefill($provider, ['verification_code' => $verification_code]);
        $this->otpService->sendOtp($provider);
        return self::success('Verification Code sent successfully!');
    }

    public function verifyAccount(VerifyAccountRequest $request): \Illuminate\Http\Response
    {
        $provider = $this->provider->withCriteria(new Where('phone', $request->phone))->firstOrFail();
        if ($provider->verification_code != $request->verification_code) {
            return self::failure('Wrong Verification Code!', 400);
        }
        $this->provider->forceFill($provider, ['phone_verified_at' => now(), 'status' => 'active']);
        return self::success('Success!');
    }
}
