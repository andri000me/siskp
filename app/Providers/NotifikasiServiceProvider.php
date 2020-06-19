<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class NotifikasiServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        view()->composer('template', function ($view){
            if(\Session::has('admin')){
                $view->with('notifikasi', \App\NotifikasiAdmin::where('dibaca', 'tidak')->get());
            }elseif(\Session::has('dosen')){
                $view->with('notifikasi', \App\NotifikasiDosen::where('dibaca', 'tidak')->where('id_dosen', \Session::get('id'))->get());
            }elseif(\Session::has('mahasiswa')){
                $view->with('notifikasi', \App\NotifikasiMahasiswa::where('dibaca', 'tidak')->where('id_mahasiswa', \Session::get('id'))->get());
            }
            $view->with('pengaturan', \App\Pengaturan::find(1));
        });
    }
}
