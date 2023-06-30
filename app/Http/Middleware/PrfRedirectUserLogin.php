<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class PrfRedirectUserLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if($request->session()->has('prf_user')){
            return redirect('/PRF/dashboard');
        } 
        return $next($request);
    }
}
