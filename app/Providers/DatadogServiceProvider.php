<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use DataDog\DogStatsd;

class DatadogServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(DogStatsd::class, function ($app) {
            return new DogStatsd([
                'host' => env('DD_DOGSTATSD_HOST', 'localhost'),
                'port' => env('DD_DOGSTATSD_PORT', 8125),
                'global_tags' => [
                    'service:' . env('DD_SERVICE', 'laravel-app'),
                    'env:' . env('DD_ENV', 'local'),
                    'version:' . env('DD_VERSION', '1.0.0'),
                ],
            ]);
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
