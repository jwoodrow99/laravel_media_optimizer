# laravel_media_optimizer

Add provider to the config/app.php file
```
jwoodrow99\laravel_media_optimizer\LaravelMediaOptimizerServiceProvider::class
```

Publish FFMpeg config
```
php artisan vendor:publish --provider="ProtoneMedia\LaravelFFMpeg\Support\ServiceProvider"
```

Publish LaravelMediaOptimizer config
```
php artisan vendor:publish --provider="jwoodrow99\laravel_media_optimizer\LaravelMediaOptimizerServiceProvider"
```
