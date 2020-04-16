<?php

namespace App\Providers;

use App\Service\SearchService;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class FacadesServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        App::bind('search', function(){
            return new SearchService();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
