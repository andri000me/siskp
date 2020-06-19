<?php

namespace App\Http\Middleware;

use Closure;
use Session;

class MahasiswaMiddleware
{
    public function handle($request, Closure $next)
    {
        if(!(Session::has('mahasiswa'))) 
        {
            Session::flash('pesan', 'Oops.. Anda bukan mahasiswa!');
            return redirect('/');
        }
        return $next($request);
    }
}
