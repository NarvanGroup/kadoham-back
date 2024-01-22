<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class RoleCheck
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Cache::get($request->bearerToken())['user'];
        if ($request->filled('user_id') && $user['mobile'] !== $request->input('user_id') && !$user->hasRole('Super-Admin')) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        if (!$request->filled('user_id')) {
            $request->merge(['user_id' => $user['mobile']]);
        }

        return $next($request);
    }
}
