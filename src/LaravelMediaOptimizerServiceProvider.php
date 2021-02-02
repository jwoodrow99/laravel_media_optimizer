<?php

namespace jwoodrow99\laravel_media_optimizer;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;
// use ProtoneMedia\LaravelFFMpeg\Support\ServiceProvider;

class LaravelMediaOptimizerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // $this->app->register(ProtoneMedia\LaravelFFMpeg\Support\ServiceProvider::class);
        // AliasLoader::getInstance(['FFMpeg' => 'ProtoneMedia\LaravelFFMpeg\Support\FFMpeg']);
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
