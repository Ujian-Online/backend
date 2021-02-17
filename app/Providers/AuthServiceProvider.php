<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Access\Response;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        // Laravel Policies
        $this->registerPolicies();

        // Laravel Passport Routes
        Passport::routes();

        // Authentication Checker for Admin
        Gate::define('isAdmin', function ($user) {
            return $user->type == 'admin';
        });

        // Authentication Checker for TUK
        Gate::define('isTuk', function ($user) {
            return $user->type == 'tuk';
        });

        // Authentication Checker for Assesor
        Gate::define('isAssesor', function ($user) {
            return $user->type == 'assesor';
        });

        // Authentication Checker for Asessi
        Gate::define('isAsessi', function ($user) {
            return $user->type == 'asessi';
        });

        // Authentication For Admin and TUK
        Gate::define('isAdminTuk', function ($user) {
            return $user->type == 'admin' OR $user->type == 'tuk';
        });

        // Authentication For Admin, TUK or Asesor
        Gate::define('isAdminTukAsesor', function ($user) {
            return $user->type == 'admin' OR $user->type == 'tuk' OR $user->type == 'assesor';
        });

        // Authentication For Admin and Asesor
        Gate::define('isAdminAsesor', function ($user) {
            return $user->type == 'admin' OR $user->type == 'assesor';
        });
    }
}
