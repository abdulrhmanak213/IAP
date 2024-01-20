<?php

namespace App\Services;

use App\Models\File;

class UploadFileService
{
    public function upload($record, $file, $collection)
    {
        $record->addMedia($file)->toMediaCollection($collection);
    }

    public function getUserFilesCount($user): int
    {
        return File::query()->where('owner_id', $user->id)->count();
    }
}
