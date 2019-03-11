<?php

namespace HelloVideo\Http\Middleware;

use Closure;

use Auth;

class demo
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
      if (!Auth::guest() && Auth::user()->role == 'demo'){
          return redirect()->back()->with(array('note' => 'Sorry, unfortunately this functionality is not available in demo accounts', 'note_type' => 'error'));
        }
        return $next($request);
    }
}
