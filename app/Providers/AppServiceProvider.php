<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Policies\GeneralPolicy;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Register any application services here
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Manually define general abilities using the GeneralPolicy methods
        Gate::define('admin', [GeneralPolicy::class, 'admin']);
        Gate::define('baristaOrAdmin', [GeneralPolicy::class, 'baristaOrAdmin']);
        Gate::define('buyer', [GeneralPolicy::class, 'buyer']);
    }
}
