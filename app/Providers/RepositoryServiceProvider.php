<?php

namespace App\Providers;

use App\Interfaces\HeadOfFamilyRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Repositories\HeadOfFamilyRepository;
use App\Repositories\UserRespository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, UserRespository::class);
        $this->app->bind(HeadOfFamilyRepositoryInterface::class, HeadOfFamilyRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
