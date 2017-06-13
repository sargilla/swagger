<?php

Route::any(config('swagger.doc-route') . '/{page?}', [
    'as' => 'swaggervel.definitions',
    'uses' => 'SwaggervelController@definitions',
]);

Route::get(config('swagger.api-docs-route'), [
    'as' => 'swagger.ui',
    'uses' => 'SwaggervelController@ui',
]);
