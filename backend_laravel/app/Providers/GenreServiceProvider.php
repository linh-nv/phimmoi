<?php

namespace App\Providers;

use App\Repositories\Genre\GenreRepository;
use App\Repositories\Genre\GenreRepositoryInterface;
use App\Services\GenreService;
use Illuminate\Support\ServiceProvider;


class GenreServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register()
    {
        $this->app->bind(GenreRepositoryInterface::class, GenreRepository::class);

        $this->app->singleton(GenreService::class, function ($app) {
            return new GenreService($app->make(GenreRepositoryInterface::class));
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
