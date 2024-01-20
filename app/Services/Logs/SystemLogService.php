<?php

namespace App\Services\Logs;

use App\Models\Setting;
use App\Models\SystemLog;

class SystemLogService
{

    public function store($data)
    {
        SystemLog::query()->create($data);
    }

    public function checkLogLevel()
    {
        $logCount = SystemLog::query()->count();
        $logLevel = Setting::query()->where('key', 'log_level')->first()->value('value');
        if ($logCount > $logLevel) {
            $ids = SystemLog::query()->select('id')->latest()->take($logLevel)->get();
            SystemLog::query()->whereNotIn('id', $ids)->delete();
        }
    }
}

