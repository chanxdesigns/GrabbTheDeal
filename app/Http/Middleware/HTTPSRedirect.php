<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;

class HTTPSRedirect
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
        if(!$request->isSecure() && env('APP_ENV') === 'production') {
            return redirect($request->getRequestUri(),'301',[],true);
        }
        return $next($request);
    }
}
