<?php

namespace App\Http\Middleware;

use Closure;

class Common
{
    /**
     * @param $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        context()->set('request_start_time', get_millisecond());
        set_request_context();

        return $next($request);
    }
}
