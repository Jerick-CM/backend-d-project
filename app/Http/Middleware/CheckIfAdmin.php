<?php

namespace App\Http\Middleware;

use Closure;
use Takaworx\Brix\Entities\ApiResponse;
use Takaworx\Brix\Exceptions\ApiException;

class CheckIfAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->user()->is_admin) {
            return $next($request);
        }

        return ApiResponse::exception(ApiException::unauthorized());
    }
}
