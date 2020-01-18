<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class RedirectIfNotHasCompany
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
        if(!Auth::user()->company()->count()){
          return back()->withErrors(trans('app.create_company'));
        }
        return $next($request);
    }
}
