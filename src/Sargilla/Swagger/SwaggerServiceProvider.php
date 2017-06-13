<?php

namespace Sargilla\Swagger;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class SwaggerServiceProvider extends ServiceProvider {

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot() {

        // this publishes the default configuration to the user's application config directory
        $this->publishes([
            __DIR__.'/../../config/swagger.php' => config_path('swagger.php'),
        ]);

        // this publishes the assets required to run swagger-ui
        $this->publishes([
            __DIR__.'/../../../public' => public_path('vendor/swagger'),
        ], 'public');

        $this->loadViewsFrom(__DIR__.'/../../views', 'swagger');

        // this gives the user the opportunity to override the swagger index blade file
        $this->publishes([
            __DIR__.'/../../views' => base_path('resources/views/vendor/swagger'),
        ], 'views');

        if (!$this->app->routesAreCached()) {
            Route::group(['namespace' => 'Sargilla\Swagger\Http\Controllers'], function ($router) {
                require __DIR__ . '/Http/routes.php';
            });
        }
    }
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../../config/swagger.php', 'swagger'
        );
    }
}
