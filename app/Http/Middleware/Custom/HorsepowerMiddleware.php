<?php

namespace App\Http\Middleware\Custom;

use Closure;

class HorsepowerMiddleware
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
        if($request->session()->has('index') && $request->session()->has('token'))
            return $next($request);
        else
            return redirect('error');
    }
}