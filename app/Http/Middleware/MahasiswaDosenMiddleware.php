<?php

namespace App\Http\Middleware;

use Closure;
use Session;

class MahasiswaDosenMiddleware
{
    public function handle($request, Closure $next)
    {
        if(Session:: has('mahasiswa') || Session::has('dosen')) 
        {
            return $next($request);    
        }else{
            Session::flash('pesan', 'Oops.. Anda bukan dosen atau mahasiswa!');
            return redirect('/');
        }
    }
}
