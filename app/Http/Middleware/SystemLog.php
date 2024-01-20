<?php

namespace App\Http\Middleware;

use App\Services\Logs\SystemLogService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SystemLog
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $request_body = $request->all();
        $response = $next($request);
        $logService = new SystemLogService();
        $user = auth()->user();
        $data = [
            'verb' => $request->method(),
            'request_body' => json_encode($request_body),
            'route' => $request->getUri(),
            'response_body' => $response->getContent(),
            'response_code' => $response->getStatusCode(),
        ];
        if ($user) {
            $data['user_id'] = $user->id;
        }
        $logService->store($data);
        $logService->checkLogLevel();
        return $response;
    }
}
