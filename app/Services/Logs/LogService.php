<?php

namespace App\Services\Logs;

use App\Repositories\Contracts\IFileLog;

class LogService
{
    private IFileLog $fileLog;

    public function __construct(IFileLog $fileLog)
    {
        $this->fileLog = $fileLog;
    }

    public function store($files, $user, $operation)
    {
        foreach ($files as $file) {
            $this->fileLog->create([
                'file_id' => $file->id,
                'user_id' => $user->id,
                'operation' => $operation,
            ]);
        }
    }
}
