<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Contracts\IFile;
use App\Models\File;

class FileRepository extends BaseRepository implements IFile
{
    public function model(): string
    {
        return File::class;
    }
}
