<?php

namespace App\Providers;

use App\Models\User;
use App\Observers\UserObserver;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use App\Console\Commands\ModelMakeCommand;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->extend('command.model.make', function ($command, $app) {
            return new ModelMakeCommand($app['files']);
        });

        User::observe(UserObserver::class);

        Blade::if('manager', function(){
            return auth()->check() && auth()->user()->manager;
        });
    }
}
