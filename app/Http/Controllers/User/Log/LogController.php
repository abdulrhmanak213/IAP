<?php

namespace App\Http\Controllers\User\Log;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\Log\LogResource;
use App\Models\File;
use App\Models\FileLog;

class LogController extends Controller
{
    // Returns a report for a file with the user and it's operation
    public function index(File $file)
    {
        $logs = FileLog::query()->with('user')->whereHas('file', function ($query) use ($file) {
            $query->where('id', $file->id);
        })->get();
        return self::returnData('logs', LogResource::collection($logs));
    }
}
