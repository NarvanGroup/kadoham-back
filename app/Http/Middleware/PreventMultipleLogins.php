<?php

namespace App\Http\Middleware;

use App\Traits\Api\V1\ResponderTrait;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class PreventMultipleLogins
{
    use ResponderTrait;

    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::guard('sanctum')->check()) {
            return $this->responseForbidden('Already logged in');
        }

        return $next($request);
    }
}
