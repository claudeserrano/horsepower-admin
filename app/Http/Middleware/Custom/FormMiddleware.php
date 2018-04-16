<?php

namespace App\Http\Middleware\Custom;

use Closure;

class FormMiddleware
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
        if(!$request->session()->has('lang'))
            session(['lang' => 'en']);

        return $next($request);
    }
}
