<?php

namespace App\Http\Middleware;

use Closure;

class HorsepowerMiddleWare
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
        // if ($request->age <= 200) {
        //     return view('error');
        // }

        return $next($request);
    }
}