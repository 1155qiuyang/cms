<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        if($request->user()->role=='admin'){

            return $next($request);
        }
        else {
            $request()->session()->flash('error','You do not have any permission to access this page');
            return redirect()->route($request->user()->role);
        }
        
    }
}
