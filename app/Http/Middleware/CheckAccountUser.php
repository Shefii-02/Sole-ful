<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckAccountUser
{
    public function handle(Request $request, Closure $next)
    {
        
        if (Auth::check() && auth('web')->user()->type == 'user') {
            return $next($request);
        } else {
            return redirect()->route('login');
        }
        
    }
}
