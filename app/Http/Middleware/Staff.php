<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Helpers\ResponseHelper;

class Staff
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $user = Auth::user();
        $role = $user->role;

        if($role != 'staff'){
            return ResponseHelper::error_response(
                'You do not have the permission to access this resource',
                null,
                401
            );
        }

        return $next($request);
    }
}
