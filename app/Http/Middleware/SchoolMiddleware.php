<?php

namespace App\Http\Middleware;

use Closure;
use Redirect;
use Auth;
class SchoolMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    /*Check if school is logged in or not*/
    public function handle($request, Closure $next)
    {
        if(Auth::check() && Auth::user()->type == "S"){
            $status = Auth::user()->status;
            if($status == "0"){
                Auth::logout();
                return Redirect::to('/login')->with("error","Your account has been suspended");
            }
            return $next($request);    
        }else{
            return Redirect::to('/login');
        }
    }
}
