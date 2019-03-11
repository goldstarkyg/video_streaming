<?php

namespace HelloVideo\Http\Middleware;

use HelloVideo\Models\Setting;
use Closure;

class Secure
{

	public function handle($request, Closure $next)
	{
		$settings = Setting::first();

		if (!$request->secure() && $settings->enable_https) {
			if($request->header('x-forwarded-proto') <> 'https'){
        		return redirect()->secure($request->getRequestUri());
	    	}
		}
		
		return $next($request);
	}

}
