<?php

namespace App\Providers;

use App\Repositories\Services\DashboardFacadeService;
use App\Repositories\Services\DirectoryFacadeService;
use App\Repositories\Services\ShortenUrlFacadeService;
use App\Repositories\Services\VisitorFacadeService;
use Illuminate\Support\ServiceProvider;

class FacadeServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('dashboard-facade-service', function () {
            return new DashboardFacadeService();
        });

        $this->app->bind('shorten-url-facade-service', function () {
            return new ShortenUrlFacadeService();
        });

        $this->app->bind('directory-facade-service', function () {
            return new DirectoryFacadeService();
        });

        $this->app->bind('visitor-facade-service', function () {
            return new VisitorFacadeService();
        });

        // Register more  facade services.
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
