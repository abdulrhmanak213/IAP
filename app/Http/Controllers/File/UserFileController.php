<?php

namespace App\Http\Controllers\File;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\UserResource;
use App\Models\File;
use App\Models\User;
use App\Repositories\Contracts\IFile;
use App\Repositories\Contracts\IFileLog;
use App\Repositories\Contracts\IUser;
use App\Repositories\Eloquent\Criteria\OrWhereHas;
use App\Repositories\Eloquent\Criteria\Where;
use App\Repositories\Eloquent\Criteria\WhereHas;

class UserFileController extends Controller
{
    private $file, $user, $fileLog;

    public function __construct(IFile $file, IUser $user, IFileLog $fileLog)
    {
        $this->user = $user;
        $this->file = $file;
        $this->fileLog = $fileLog;
    }

    // Returns users that have access to a file (without the current user)
    public function index($id): \Illuminate\Http\Response
    {
        $user = auth()->user();
        $users = $this->user->withCriteria(
            new Where('id', $user->id, '<>'),
            new WhereHas('files', function ($query) use ($id) {
                $query->where('id', $id);
            }),
            new OrWhereHas('userFiles', function ($query) use ($id) {
                $query->where('file_id', $id);
            }),
        )->all();
        return self::returnData('users', UserResource::collection($users));
    }

    // Adds a user to a file (By the file owner)
    public function store(User $user, File $file)
    {
        $authUser = auth()->user();
        if ($file->owner_id != $authUser->id) {
            return self::failure('UnAuthorized', 403);
        }
        elseif ($file->owner_id == $user->id) {
            return self::failure('user already in file!', 403);
        }
        // Syncing Many-To-Many
        $file->userFiles()->syncWithoutDetaching([$user->id]);
        // Reporting
        $this->fileLog->create([
            'file_id' => $file->id,
            'user_id' => $authUser->id,
            'operation' => 'add-user',
        ]);
        return self::returnData('user', $user, null, 'User Added Successfully To File!');
    }

    // Removes a user from a file (By the file owner)
    public function destroy(User $user, File $file)
    {
        $authUser = auth()->user();
        if ($file->owner_id != $authUser->id) {
            return self::failure('UnAuthorized', 403);
        }
        // Syncing Many-To-Many
        $file->userFiles()->detach([$user->id]);
        // Reporting
        $this->fileLog->create([
            'file_id' => $file->id,
            'user_id' => $authUser->id,
            'operation' => 'remove-user',
        ]);
        return self::returnData('user', $user, null, 'User Deleted Successfully from File!');
    }
}
