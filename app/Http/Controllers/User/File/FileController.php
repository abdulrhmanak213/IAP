<?php

namespace App\Http\Controllers\User\File;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\File\FileRequest;
use App\Http\Requests\User\File\lockRequest;
use App\Http\Resources\User\File\FileIndexResource;
use App\Models\File;
use App\Models\FileLog;
use App\Repositories\Contracts\IFile;
use App\Repositories\Eloquent\Criteria\LockForUpdate;
use App\Repositories\Eloquent\Criteria\OrWhere;
use App\Repositories\Eloquent\Criteria\OrWhereHas;
use App\Repositories\Eloquent\Criteria\Where;
use App\Repositories\Eloquent\Criteria\WhereHas;
use App\Repositories\Eloquent\Criteria\With;
use App\Services\Logs\LogService;
use App\Services\UploadFileService;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class FileController extends Controller
{
    private IFile $file;
    private UploadFileService $uploadFileService;
    private LogService $logService;

    public function __construct(IFile $file, UploadFileService $uploadFileService, LogService $logService)
    {
        $this->file = $file;
        $this->uploadFileService = $uploadFileService;
        $this->logService = $logService;
    }

    // Returns Files Owned by the current user
    public function ownerFiles(): Response
    {
        $user = auth()->user();
        $files = $this->file->withCriteria(
            new With(['media', 'folder']),
            new Where('owner_id', $user->id),
        )->all();
        return self::returnData('files', FileIndexResource::collection($files));

    }

    // Returns Files where the current user ownes or has access to
    public function index(): Response
    {
        $user = auth()->user();
        $files = $this->file->withCriteria(
            new With(['media', 'userFiles', 'folder']),
            new Where('owner_id', $user->id),
            new orWhereHas('userFiles', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            },)
        )->all();
        return self::returnData('files', FileIndexResource::collection($files));
    }

    // Stores a new file owned by the current user
    public function store(FileRequest $request): Response
    {
        $user = auth()->user();
        $file = $this->file->create(['owner_id' => $user->id]);
        $this->uploadFileService->upload($file, $request->file, 'file');
        return self::returnData('file', FileIndexResource::make($file));
    }

    // Returns a single File that the current user ownes or has access to
    public function show($id): Response
    {
        $user = auth()->user();
        $file = $this->file->withCriteria(
            new With(['media', 'userFiles']),
            new WhereHas('userFiles', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            },),
            new OrWhere('owner_id', $user->id),
        )->findOrFail($id);
        return self::returnData('file', FileIndexResource:: make($file));
    }

    // Updates a certain file
    public function update($id, FileRequest $request)//: Response
    {
        $user = auth()->user();
        // Finds the file and locks it
        $file = $this->file->withCriteria(
            new LockForUpdate(),
            new Where('status', 0),
            new Where('owner_id', $user->id),
            new orWhereHas('userFiles', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            },)
        )->findOrFail($id);
        // Updates the file
        $this->file->clearMediaCollection($file, 'file');
        $this->file->addMedia($file, $request->file, 'file');
        // Reporting
        FileLog::query()->create([
            'file_id' => $file->id,
            'user_id' => $user->id,
            'operation' => 'update',
        ]);
        return self::returnData('file', FileIndexResource::make($file));
    }

    // Deletes a file (Only the owner has access to that)
    public function destroy($id): Response
    {
        $user = auth()->user();
        $file = $this->file->findOrFail($id);
        if ($user->id != $file->owner_id) {
            return self::failure('Un Authorized User', 403);
        }
        $this->file->delete($id);
        return self::success('deleted successfully!');
    }

    // Toggles the status of the file (Locked - Free)
    public function statusToggle($id): Response
    {
        $user = auth()->user();
        $file = $this->file->withCriteria(
            new Where('owner_id', $user->id),
            new orWhereHas('userFiles', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            },)
        )->findOrFail($id);
        $file->status = !$file->status;
        $file->save();
        return self::returnData('file', FileIndexResource::make($file));
    }

    // Locks a Bulk of files (all of them must be free)
    public function lock(LockRequest $request): Response
    {
        $user = auth()->user();
        $filesIds = $request->get('files');
        $files = File::query()->whereIn('id', $filesIds)->where('status', 0)->get();
        if (count($files) != count($filesIds)) {
            return self::failure('error, some files locked', 400);
        }
        $this->updateFilesStatus($filesIds, 1);
        // Reporting
        $this->logService->store($files, $user, 'check-in');
        return self::success('files locked successfully!');
    }

    // Unlocks a Bulk of files
    public function unLock(LockRequest $request): Response
    {
        $filesIds = $request->get('files');
        $files = File::query()->whereIn('id', $filesIds)->where('status', 1)->get();
        $user = auth()->user();
        $this->updateFilesStatus($filesIds, 0);
        // Reporting
        $this->logService->store($files, $user, 'check-out');
        return self::success('files release successfully!');
    }

    public function getFilesIds($files): array
    {
        $files = Str::of($files)->remove(']');
        $files = Str::of($files)->remove('[');
        return array_map('intval', explode(',', $files));
    }

    public function updateFilesStatus($files, $status)
    {
        File::query()
            ->whereIn('id', $files)
            ->update(['status' => $status]);
    }

//    public function addFileLogs($files, $user, $operation)
//    {
//        foreach ($files as $file) {
//            FileLog::query()->create([
//                'file_id' => $file->id,
//                'user_id' => $user->id,
//                'operation' => $operation,
//            ]);
//        }
//    }
}
