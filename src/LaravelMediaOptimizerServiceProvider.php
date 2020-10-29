<?php

namespace jwoodrow99\laravel_video_optimizer;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class LaravelMediaOptimizerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {

            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('laravel-media-optimizer.php'),
            ], 'config');

        }
    }
}
