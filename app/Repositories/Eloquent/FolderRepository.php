<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Contracts\IFolder;
use App\Models\Folder;

class FolderRepository extends BaseRepository implements IFolder
{
    public function model(): string
    {
        return Folder::class;
    }
}
