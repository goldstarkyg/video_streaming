<?php

namespace HelloVideo\Http\Middleware;

use Closure;
use Auth;
use HelloVideo\Models\Setting;

class Subscribed
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

      if (!Auth::guest()){
         $settings = Setting::first();
         $free_registration = $settings->free_registration;

        $params = \Route::current()->parameters();

        $video_url = (isset($params['id'])) ? "&id=".$params['id'] : '';

//          if( (!Auth::user()->subscribed() && Auth::user()->role == 'subscriber') || (!$free_registration && Auth::user()->role == 'registered') ){
         if( (!Auth::user()->stripe_subscription=='1' && Auth::user()->role == 'subscriber') || (!$free_registration && Auth::user()->role == 'registered') ){
           $user = Auth::user();
             return redirect('user/' . $user->username . "/renew_subscription?plan=3$video_url")->with(array('note' => 'Uh oh, looks like you don\'t have an active subscription, please renew to gain access to all content', 'note_type' => 'error'));
         }
       }
        return $next($request);
    }
}
