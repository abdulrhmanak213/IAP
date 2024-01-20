<?php

namespace App\Http\Controllers\Admin\SystemLog;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\SystemLog\SystemLogResource;
use App\Models\SystemLog;
use Illuminate\Http\Request;

class SystemLogController extends Controller
{
    // Returns System Logs
    public function index(): \Illuminate\Http\Response
    {
        $logs = SystemLog::all();
        return self::returnData('logs',SystemLogResource::collection($logs));
    }
}
