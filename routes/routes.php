<?php

Route::any(config('swagger.doc-route') . '/{page?}', [
    'as' => 'swagger.definitions',
    'uses' => 'SwaggerController@definitions',
]);

Route::get(config('swagger.api-docs-route'), [
    'as' => 'swagger.ui',
    'uses' => 'SwaggerController@ui',
]);
