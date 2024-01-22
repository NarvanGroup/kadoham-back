<?php

namespace App\Http\Middleware\V1;

use App\Traits\Api\V1\ResponderTrait;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class CacheAuth
{
    use ResponderTrait;

    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Cache::has($request->bearerToken())) {
            return $next($request);
        }

        return $this->responseUnauthorized();
    }
}
