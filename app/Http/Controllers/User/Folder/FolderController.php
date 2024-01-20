<?php

namespace App\Http\Controllers\User\Folder;

use App\Http\Controllers\Controller;
use App\Http\Requests\FolderRequest;
use App\Repositories\Contracts\IFile;
use App\Repositories\Contracts\IFolder;
use App\Repositories\Eloquent\Criteria\Where;
use App\Repositories\Eloquent\Criteria\WhereIn;
use Illuminate\Http\Response;

class FolderController extends Controller
{
    private $folder, $file;

    public function __construct(IFolder $folder, IFile $file)
    {
        $this->file = $file;
        $this->folder = $folder;
    }

    // Creates a Folder and adds files to it
    public function store(FolderRequest $request): Response
    {
        $filesIds = $request->get('files');
        $user = auth()->user();
        $files = $this->file->withCriteria(new Where('owner_id', $user->id), new WhereIn('id', $filesIds))->all();
        if (count($files) != count($filesIds)) {
            return self::failure('Unauthorized', 400);
        }
        $folder = $this->folder->create(['owner_id' => $user->id, 'name' => $request->name]);
        $this->file->withCriteria(new Where('owner_id', $user->id), new WhereIn('id', $filesIds))->updateInstance(['folder_id' => $folder->id]);
//        File::query()->where('owner_id', $user->id)->whereIn('id', $filesIds)->update(['folder_id' => $folder->id]);
        return self::success('Folder created successfully!');
    }

    // Deletes a Folder
    public function destroy($id): Response
    {
        $folder = $this->folder->findOrFail($id);
        $user = auth()->user();
        if ($folder->owner_id != $user->id) {
            return self::failure('un authorized', 403);
        }
        $folder->delete();
        return self::success('folder deleted successfully!');
    }
}
