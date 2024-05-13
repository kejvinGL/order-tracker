<?php

namespace KejvinGL\OrderTracker;

use Illuminate\Support\ServiceProvider;

class OrderTrackerServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/config/order-tracker.php' => config_path('order-tracker.php'),
        ],['order-tracker', 'order-tracker-config']);

        $this->publishesMigrations([__DIR__ . '/migrations' => database_path('migrations'),
        ], ['order-tracker', 'order-tracker-migrations']);

        $this->publishes([
            __DIR__ . '/resources/views' => resource_path('views/vendor/order-tracker'),
        ], ['order-tracker', 'order-tracker-views']);

        $this->publishes([
            __DIR__.'/public' => public_path('vendor/kejvingl/order-tracker'),
        ], ['order-tracker', 'order-tracker-views']);

        $this->mergeConfigFrom(__DIR__ . '/config/order-tracker.php', 'order-tracker');
        $this->loadRoutesFrom(__DIR__ . '/routes/web.php');

    }

    public function register()
    {

    }
}
