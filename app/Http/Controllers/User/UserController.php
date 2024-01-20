<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use App\Repositories\Contracts\IFile;
use App\Repositories\Contracts\IUser;
use App\Repositories\Eloquent\Criteria\OrWhereHas;
use App\Repositories\Eloquent\Criteria\Select;
use App\Repositories\Eloquent\Criteria\WhereHas;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private $file, $user;

    public function __construct(IFile $file, IUser $user)
    {
        $this->user = $user;
        $this->file = $file;
    }

    // Finds all the users that does not have access to a certain file
    public function index(Request $request)
    {
        $users = $this->user->withCriteria(
            new Select(['id', 'name', 'email']),
            new WhereHas('files', function ($query) {
                $query->where('id', request()->file_id);
            }),
            new OrWhereHas('userFiles', function ($query) {
                $query->where('file_id', request()->file_id);
            }),
        )->all();
        $users = User::query()->whereNotIn('id', $users->pluck('id'))->get();
        return self::returnData('users', UserResource::collection($users));
    }
}
