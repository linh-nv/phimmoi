<?php

namespace App\Providers;

use App\Repositories\Country\CountryRepository;
use App\Repositories\Country\CountryRepositoryInterface;
use App\Services\CountryService;
use Illuminate\Support\ServiceProvider;


class CountryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register()
    {
        $this->app->bind(CountryRepositoryInterface::class, CountryRepository::class);

        $this->app->singleton(CountryService::class, function ($app) {
            return new CountryService($app->make(CountryRepositoryInterface::class));
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
