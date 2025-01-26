<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckAccountAdmin
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && auth('web')->user()->type == 'superadmin') {
             return $next($request);
        }
        else {
            return redirect()->route('login');
        }

    }
}
