<?php

namespace App\Http\Middleware;

use App\Services\SettingService;
use App\Services\UploadFileService;
use App\Traits\HttpResponse;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckFileCount
{
    use HttpResponse;

    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $settingService = new SettingService();
        $fileService = new UploadFileService();
        $user = auth()->user();
        $filesCount = $fileService->getUserFilesCount($user);
        $maxFileCount = $settingService->getSetting('max_files');
        if ($filesCount >= $maxFileCount) {
            return self::failure('you have reached the maximum number of files', 400);
        }
        return $next($request);
    }
}
