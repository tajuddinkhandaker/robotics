<?php

namespace Robotics\Http\Middleware;

use Closure;
use \Symfony\Component\HttpFoundation\Request;

/*
 * A middleware that forces to use https
 */
class HttpsProtocol
{

    public function handle($request, Closure $next)
    {
        if (!$request->secure() && config('app.env') === 'production')
        {
        	$request->setTrustedProxies( [ $request->getClientIp() ], Request::HEADER_X_FORWARDED_ALL );
            return redirect()->secure($request->getRequestUri());
        }

        return $next($request); 
    }
}