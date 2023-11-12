<?php

namespace App\Providers;

use App\Services\V1\DataProviderXService;
use App\Services\V1\DataProviderYService;
use App\Services\V1\UserService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //

        $this->app->bind(UserService::class, function ($app) {
            $dataProviderXService = $app->make(DataProviderXService::class);
            $dataProviderYService = $app->make(DataProviderYService::class);

            return new UserService([$dataProviderXService, $dataProviderYService]);
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
