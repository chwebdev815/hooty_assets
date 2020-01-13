<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Redirect
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    protected $table = 'subscriptions';
    public function handle($request, Closure $next)
    {
        $user = auth()->guard('web')->user();
        $request_url = \Request::getRequestUri();

        if (!empty($user)) {
            error_log("AGAIN!!");
            if (($request->session()->has('redirect_to'))) {
                $redirect_url = $request->session()->get('redirect_to');
                $request->session()->forget('redirect_to');
                error_log("KKKKKKK!!!");
                error_log($redirect_url);
                return redirect($redirect_url);
            } else {
                if ($user->subscribed('main')) {
                    error_log("IS SUBSCRIBED!!");
                    error_log($request_url);
                    if ($request_url !== "/plan/lite/monthly" && $request_url !== "/plan/lite/yearly" && $request_url !== "/plan/view") {
                        return $next($request);
                    } else {
                        return redirect("/");
                    }
                } else {
                    if ($request_url !== "/plan/lite/monthly" && $request_url !== "/plan/lite/yearly" && $request_url !== "/plan/view") {
                        return redirect('/plan/view');
                    } else {
                        error_log("NOT SUBSCRIBED!!");
                        return $next($request);
                    }
                }
            }
        } else {
            if ($request_url == "/plan/lite/monthly" || $request_url == "/plan/lite/yearly") {
                $request->session()->put('redirect_to', $request_url);
            }
            return redirect('/register');
        }

    }
}
