<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
    
class IsAdmin
{
    public function handle($request, Closure $next)
    {
        
    if ( Auth::user()->user_role[0]->role == 'admin') 
    {
            return $next($request);
     }

    return redirect('/login');
    }
}
