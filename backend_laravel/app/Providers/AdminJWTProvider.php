<?php

namespace App\Providers;

use App\JWT\Admin\AdminJWT;
use App\JWT\Admin\AdminJWTInterface;
use App\Repositories\Admin\AdminRepositoryInterface;
use App\Services\AdminService;
use Illuminate\Support\ServiceProvider;


class AdminJWTProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register()
    {
        $this->app->bind(AdminJWTInterface::class, AdminJWT::class);

        $this->app->singleton(AdminService::class, function ($app) {
            return new AdminService($app->make(AdminRepositoryInterface::class), $app->make(AdminJWTInterface::class));
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
