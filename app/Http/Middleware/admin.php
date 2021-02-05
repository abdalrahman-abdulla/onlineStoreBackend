<?php

namespace App\Http\Middleware;

use Closure;

class admin
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
        try {
            if(auth()->user()->user_type == 0){
                return $next($request);
            }
            else{
                return response()->json('not authorized', 401);
            }
        } catch (\Throwable $th) {
            return response()->json('not authorized', 401);
        }

    }
}
