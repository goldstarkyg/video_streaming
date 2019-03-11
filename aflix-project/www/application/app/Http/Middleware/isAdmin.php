<?php

namespace HelloVideo\Http\Middleware;

use Closure;
use Auth;

class isAdmin
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

      if(Auth::user()->role != 'admin' && (Auth::user()->role != 'registered' || Auth::user()->contribute != 'contribute')){
        die('Sorry ' . Auth::user()->role . ' users do not have access to this area');
      }
      return $next($request);
    }
}
