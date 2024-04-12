<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RepositoryServiceProvider::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // pagination
        Paginator::useBootstrapFive();

        // Domain
        $this->app->bind(\App\Domain\ClientUrl::class, \App\Domain\ClientUrlConcrete::class);

        // Service
        $this->app->bind(\App\Services\UserService::class, \App\Services\UserServiceConcrete::class);
    }
}
