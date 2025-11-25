<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
              Gate::define('see-admin-menu', function ($user) {
        return $user->isAdmin();
        
    });

                 Gate::define('see-caisse-menu', function ($user) {
        return $user->isCaisse();
        
    });

                 Gate::define('see-manager-menu', function ($user) {
        return $user->isManager();
        
    });
    
    Gate::define('see-achats', function ($user) {
        return $user->isAdmin() || $user->isManager();
    });

    Gate::define('see-ventes', function ($user) {
        return $user->isManager() || $user->isCaisse();
    });
    }
}
