<?php

namespace App\Providers;

use App\Services\RiotApiService;
use Illuminate\Support\ServiceProvider;

class RiotApiServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(RiotApiService::class, function ($app) {
            return new RiotApiService(config('services.riot.key'));
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
