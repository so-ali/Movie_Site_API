<?php

namespace App\Providers;

use App\Services\Crew\CrewService;
use App\Services\Crew\CrewServiceInterface;
use App\Services\Genre\GenreService;
use App\Services\Genre\GenreServiceInterface;
use App\Services\Movie\MovieService;
use App\Services\Movie\MovieServiceInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(MovieServiceInterface::class, MovieService::class);
        $this->app->bind(CrewServiceInterface::class, CrewService::class);
        $this->app->bind(GenreServiceInterface::class, GenreService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
