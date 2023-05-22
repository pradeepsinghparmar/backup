<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AccountChacker
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
        if(auth()->check()){
            
           if(auth()->user()->login_status == '0'){
               return redirect()->route('getLogin')->with('error','Your Account is inactive contact to admin');
           }
        }else{
            return redirect()->route('getLogin')->with('error','You have to be logged in to access this page');
        }
        return $next($request);
    }
}