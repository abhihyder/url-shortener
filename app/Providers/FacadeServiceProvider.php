<?php

namespace App\Providers;

use App\Repositories\Services\BannerFacadeService;
use App\Repositories\Services\DashboardFacadeService;
use App\Repositories\Services\DirectoryFacadeService;
use App\Repositories\Services\PaymentMethodFacadeService;
use App\Repositories\Services\ProfileFacadeService;
use App\Repositories\Services\ShortenUrlFacadeService;
use App\Repositories\Services\StatisticsFacadeService;
use App\Repositories\Services\VisitorFacadeService;
use App\Repositories\Services\WithdrawalRequestFacadeService;
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

        $this->app->bind('statistics-facade-service', function () {
            return new StatisticsFacadeService();
        });

        $this->app->bind('withdrawal-request-facade-service', function () {
            return new WithdrawalRequestFacadeService();
        });

        $this->app->bind('payment-method-facade-service', function () {
            return new PaymentMethodFacadeService();
        });

        $this->app->bind('banner-facade-service', function () {
            return new BannerFacadeService();
        });

        $this->app->bind('profile-facade-service', function () {
            return new ProfileFacadeService();
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
