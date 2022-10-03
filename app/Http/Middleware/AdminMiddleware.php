<?php

namespace App\Http\Middleware;

use Closure;
use Redirect;
use Auth;
class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    /*Check if admin is logged in or not*/
    public function handle($request, Closure $next)
    {
        if((Auth::guard("admin")->user() != null) && Auth::guard("admin")->user()->type == "A"){
            return $next($request);    
        }else{
            return Redirect::to('/admin/login');
        }
    }
}