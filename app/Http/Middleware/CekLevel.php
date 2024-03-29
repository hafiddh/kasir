<?php

namespace App\Http\Middleware;

use Session;
use Closure;

class CekLevel
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, ...$levels)
    {
        if(in_array($request -> user() ->level,$levels)){
            return $next($request);
        }
        return \redirect(route('index'))->with('error','Silakan login terlebih dahulu!');
    }
}
