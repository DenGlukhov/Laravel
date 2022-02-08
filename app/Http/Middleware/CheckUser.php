<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckUser
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
        $user = Auth::user();
        $input = $request;
        $id = preg_replace('/[^0-9]/', '', $input->server('REQUEST_URI'));
               
        if ($user->id == $id) return $next($request);
        else return redirect()->route("home");
    }
}
