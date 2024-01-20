<?php

namespace App\Http\Middleware;

use App\Traits\HttpResponse;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class TransactionHandler
{
    use HttpResponse;

    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            DB::beginTransaction();
            $response = $next($request);
            if ($response->getStatusCode() != 200) {
                DB::rollBack();
                return self::failure('error', 400);
            }
            DB::commit();
            return $response;
        } catch (\Exception $exception) {
            DB::rollBack();
            return self::failure($exception->getMessage(), 500);
        }
    }
}
