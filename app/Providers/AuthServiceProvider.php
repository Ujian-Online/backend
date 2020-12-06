<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Access\Response;

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
        $this->registerPolicies();

        // Authentication Checker for Admin
        Gate::define('isAdmin', function ($user) {
            return $user->type == 'admin'
                ? Response::allow()
                : Response::deny(
                    trans('permission.gate.error', [':access', 'Administrator'])
                );
        });

        // Authentication Checker for TUK
        Gate::define('isTuk', function ($user) {
            return $user->type == 'tuk'
                ? Response::allow()
                : Response::deny(
                    trans('permission.gate.error', [':access', 'TUK'])
                );
        });

        // Authentication Checker for Assesor
        Gate::define('isAssesor', function ($user) {
            return $user->type == 'assesor'
                ? Response::allow()
                : Response::deny(
                    trans('permission.gate.error', [':access', 'Assesor'])
                );
        });

        // Authentication Checker for TUK
        Gate::define('isAsessi', function ($user) {
            return $user->type == 'asessi'
                ? Response::allow()
                : Response::deny(
                    trans('permission.gate.error', [':access', 'Assesi'])
                );
        });
    }
}
