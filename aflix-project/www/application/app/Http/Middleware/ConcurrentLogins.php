<?php

namespace HelloVideo\Http\Middleware;

use Closure;

use Auth;
use DB;

class ConcurrentLogins
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


      if(Auth::check() && !$request->is('login') && !$request->is('logout') && !$request->is('logoutall') && !$request->is('do-logout')){
        $userId  = Auth::user()->id;

        $session_id = session('session_id');

        $exsist = DB::select("select count(*) as logins from user_logins where user_id = '$userId' and session_id = '$session_id'")[0];

        if($exsist->logins == 4){
          return redirect('/logoutall');
        }else if($exsist->logins == 0){
          Auth::logout();
          return redirect('/');
        }
      }

        return $next($request);
    }
}
