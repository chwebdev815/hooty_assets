<?php

namespace App\Http\Middleware;

use Closure;

class Referral
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
      
       if ($request->query("ref")){
           $referral = $request->query("ref");
           $request->session()->put('referral', $referral);
       };
       error_log("INMIDDILE WARE +++++++++++++++++++++++++++++");
       error_log($request->query("id"));
        
        return $next($request);
    }
}
