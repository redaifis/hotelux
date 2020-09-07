<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
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
        if(!Auth::check()){
            return response()->json('Unauthorized',422);
        }
        if(Auth::user()->role !== 'admin'){
            return response()->json('Unauthorized',422);
        }
        return $next($request);
    }
}
