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
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        if (!defined('SWAGGER_PATH')) {
            define('SWAGGER_PATH', realpath(__DIR__.'/../'));
        }
        $this->mergeConfigFrom(SWAGGER_PATH.'/config/swagger.php', 'swagger');
    }
    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot() {

        $this->publishes([SWAGGER_PATH.'/config/swagger.php' => config_path('swagger.php')]);

        $this->publishes([SWAGGER_PATH.'/public' => public_path('vendor/swagger')], 'public');

        $this->loadViewsFrom(SWAGGER_PATH.'/views', 'swagger');

        $this->publishes([
            SWAGGER_PATH.'/views' => base_path('resources/views/vendor/swagger'),
        ], 'views');

        if (!$this->app->routesAreCached()) {

            Route::group(['namespace' => 'Sargilla\Swagger\Http\Controllers'], function ($router) { 
                require SWAGGER_PATH.'/Http/routes.php';
            });
        }
    }
}
