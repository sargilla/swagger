# Swagger (Swagger integration for Laravel 5)

Este paquete integra [Swagger-php](https://github.com/zircote/swagger-php) y Swagger UI a Laravel 5.
Cuando esta en modo debug, Swagger escaneará la carpeta app (o cualquier carpeta debajo de "app-dir" y se puede cambiar desde la configuración), genera un archivo json y lo pone en el directorio "doc-dir" (/docs).

## Instalación
- Ejecute `composer require sargilla/swagger --dev` en el directorio de laravel
- Agregar`Sargilla\Swagger\SwaggerServiceProvider::class` a `app/config/app.php` .
- Ejecutar `php artisan vendor:publish --tag=public` para enviar swagger-ui a la carpeta pública (podes encontrala en public/vendor/swagger).
- Opcional: ejecuta `php artisan vendor:publish --tag=config` para copiar las configuraciones por defecto en el directorio de configuraciones de su aplicación.
- Opcional: ejecuta `php artisan vendor:publish --tag=views` para copiar el archivo de la vista a `resources/views/vendor/swagger`.

## Ejemplos (usando la configuración por defecto)
- www.tusitio.com/docs  <- Ver el .json generado por Swagger
- www.tusitio.com/api/docs <- Acceder a Swagger UI
