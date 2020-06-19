<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    
    public function register()
    {
        require_once(app_path('Helpers/TanggalHelper.php'));
    }

    public function boot()
    {
        Schema::defaultStringLength(191);
        \Carbon\Carbon::setUTF8(true);
        
        config(['app.locale' => 'id']);
        \Carbon\Carbon::setLocale('id');
        date_default_timezone_set('Asia/Makassar');

        view()->composer('template-masuk', function ($view){
            $view->with('pengaturan', \App\Pengaturan::find(1));
        });
    }
}
