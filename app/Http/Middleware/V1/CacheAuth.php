<?php

namespace App\Http\Middleware\V1;

use App\Traits\Api\V1\ResponderTrait;
use Closure;
use Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Str;
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
	    $response = Http::acceptJson()->withToken(request()->bearerToken())->get(env('SSO_URL').'/api/v1/users/profile');

		if ($response->ok() && $response->json('mobile') !== null) {
			$request->merge(['user' => $response['mobile']]);
            return $next($request);
        }

        return $this->responseUnauthorized();
    }
}
