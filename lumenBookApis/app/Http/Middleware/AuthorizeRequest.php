<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class AuthorizeRequest
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
        $secert = env('SECERT');
        $key = "Alpha";
        $requestHash = hash_hmac('sha256', $key, $secert);
        if($request->hasHeader('Authorization') && hash_equals($requestHash, $request->header('Authorization'))) {
            return $next($request);
        }
        abort(Response::HTTP_UNAUTHORIZED);
    }
}
