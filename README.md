# Swaggervel (Swagger integration for Laravel 5)

Este paquete integra [Swagger-php](https://github.com/zircote/swagger-php) y Swagger UI a Laravel 5.
Cuando esta en modo debug, Swagger escaneara la carpeta app (o cualquier carpeta debajo de "app-dir" y se puede cambiar desde la configuracion), genera un archivo json y lo pone en el directorio "doc-dir" (/docs).

## Installation
- Ejecute `composer require sargilla/swagger --dev` en el directorio de laravel
- Agregar`Sargilla\Swagger\SwaggerServiceProvider::class` a `app/config/app.php` .
- Ejecutar `php artisan vendor:publish --tag=public` to push swagger-ui to your public folder (can be found in public/vendor/swaggervel).
- Optionally run `php artisan vendor:publish --tag=config` to push the swaggervel default config into your application's config directory.
- Optionally run `php artisan vendor:publish --tag=views` to push the swaggervel index view file into `resources/views/vendor/swaggervel`.

## Examples (when using the default configuration)
- www.example.com/docs  <- You may find your automatically generated Swagger .json-File there
- www.example.com/api/docs <- Access to your Swagger UI

## Options
All options are well commented within the swagger.php config file.

## How to Use Swagger-php
The actual Swagger spec is beyond the scope of this package. All Swagger does is package up swagger-php and swagger-ui in a Laravel-friendly fashion, and tries to make it easy to serve. 

## TODO
