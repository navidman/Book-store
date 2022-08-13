<?php

namespace App\Http\Middleware;

use App\Jobs\LogJob;
use Closure;
use Illuminate\Http\Request;

class LogMiddleware
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
        //dispatch(new LogJob($request->user()->id, $request->getUri()));
        dispatch(new LogJob(rand(1, 10), $request->getUri()));
        return $next($request);
    }
}
