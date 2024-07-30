<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use JWTAuth;
use Exception;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;
use App\Helpers\ResponseHelper;


class JwtMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                return ResponseHelper::error_response(
                    'Token is Invalid',
                    null,
                    401
                );

            } elseif (
                $e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException
            ) {

                return ResponseHelper::error_response(
                    'Token is Expired',
                    null,
                    401
                );

            } else {
                return ResponseHelper::error_response(
                    'Authorization Token not found',
                    null,
                    401
                );
            }
        }


        return $next($request);
    }
}
