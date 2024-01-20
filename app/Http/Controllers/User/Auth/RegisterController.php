<?php

namespace App\Http\Controllers\User\Auth;

use App\Enums\UserRoles;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\Auth\RegisterRequest;
use App\Http\Resources\User\Auth\LoginResource;
use App\Repositories\Contracts\IUser;
use Exception;
use Illuminate\Support\Facades\DB;

class RegisterController extends Controller
{
    private $user;

    public function __construct(IUser $user)
    {
        $this->user = $user;
    }

    public function register(RegisterRequest $request): \Illuminate\Http\Response
    {
        try {
            DB::beginTransaction();
            $data = $request->only('name', 'email', 'password');
            $user = $this->user->create($data);
            $user['access_token'] = $user->createToken('user_token')->plainTextToken;
            $user['is_admin'] = UserRoles::USER;
            DB::commit();
            return self::returnData('user', LoginResource::make($user));
        } catch (Exception $ex) {
            DB::rollback();
            return self::failure($ex->getMessage(), 450);
        }
    }
}
