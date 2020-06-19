<?php

namespace App\Http\Middleware;

use Closure;
use Session;

class AdminMiddleware
{
    public function handle($request, Closure $next)
    {
        if(!(Session::has('admin'))) 
        {
            Session::flash('pesan', 'Oops.. Anda bukan admin!');
            return redirect('/');
        }
        return $next($request);
    }
}
