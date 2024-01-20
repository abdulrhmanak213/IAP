<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Contracts\IFileLog;
use App\Models\FileLog;

class FileLogRepository extends BaseRepository implements IFileLog
{
    public function model(): string
    {
        return FileLog::class;
    }
}
