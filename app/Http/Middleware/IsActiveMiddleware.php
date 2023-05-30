<?php

namespace App\Http\Middleware;

use Closure;

/**
 * Inactive user is logged out
 */
class IsActiveMiddleware
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
        $guards = array_keys(config('auth.guards')); # Obtem guards do arquivo config/auth.php
        foreach($guards as $guard){
            if(auth($guard)->check() and auth($guard)->user()->status == 'I'){
                auth($guard)->logout();
                return response()->json(['message' => 'Not authorized'], 403);
            }
        }
        return $next($request);
    }
}