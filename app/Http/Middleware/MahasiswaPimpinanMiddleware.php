<?php

namespace App\Http\Middleware;

use Closure;
use Session;

class MahasiswaPimpinanMiddleware
{
    public function handle($request, Closure $next)
    {
        if(Session:: has('mahasiswa') || Session::has('kajur') || Session::has('kaprodi') || Session::has('admin')) 
        {
            return $next($request);    
        }else{
            Session::flash('pesan', 'Oops.. Anda bukan pimpinan atau mahasiswa!');
            return redirect('/');
        }
    }
}
