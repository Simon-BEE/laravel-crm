<?php

namespace App\Providers;

use App\Auth\CacheUserProvider;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Project::class => 'App\Policies\ProjectPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Auth::provider('cache-user', function() {
            return resolve(CacheUserProvider::class);
        });

        Gate::define('show-document', function ($user, $model) {
            return $user->id === $model->customer_id;
        });
    }
}
