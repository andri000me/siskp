<?php

namespace App\Http\Middleware;

use Closure;
use Session;

class PimpinanMiddleware
{
    public function handle($request, Closure $next)
    {
        if(Session::has('kajur') || Session::has('kaprodi') || Session::has('admin')) 
        {
            return $next($request);    
        }else
        {
            Session::flash('pesan', 'Oops.. Anda bukan pimpinan!');
            return redirect('/');
        }
    }
}
