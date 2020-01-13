<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class PlanRedirection
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
        if ($request_url == "/plan/lite/monthly" || $request_url == "/plan/lite/yearly") {
            $request->session()->put('redirect_to', $request_url);
        }
    }
}
