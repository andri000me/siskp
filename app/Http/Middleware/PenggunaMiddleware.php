<?php

namespace App\Http\Middleware;

use Closure;
use Session;

class PenggunaMiddleware
{
    public function handle($request, Closure $next)
    {
        if(!(Session::has('masuk'))) 
        {
            Session::flash('pesan', 'Anda harus login terlebih dahulu!');
            return redirect('masuk');
        }
        return $next($request);
    }
}
