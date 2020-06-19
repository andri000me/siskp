<?php

namespace App\Http\Middleware;

use Closure;
use Session;

class DosenMiddleware
{
    public function handle($request, Closure $next)
    {
        if(!(Session::has('dosen'))) 
        {
            Session::flash('pesan', 'Oops.. Anda bukan dosen!');
            return redirect('/');
        }
        return $next($request);
    }
}
