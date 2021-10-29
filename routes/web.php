<?php

$router->get('/api', function () use ($router) {
    return $router->app->version();
});

## Authentication Router
$router->group(
    [
        'prefix' => 'api'
    ],
    function () use ($router) {
        $router->post('register', 'AuthController@register');
        $router->post('login', 'AuthController@login');
        $router->get('profil', 'AuthController@profil');
    }
);

## Category Router
$router->group(
    [
        'prefix' => 'api/category',
        'middleware' => ['auth:api', 'ceklevel:admin']
    ],
    function () use ($router) {
        $router->get('/', 'CategoryController@index');
        $router->post('/create', 'CategoryController@create');
        $router->post('/update/{id}', 'CategoryController@update');
        $router->delete('/delete', 'CategoryController@destroy');
    }
);

## Tag Router
$router->group(
    [
        'prefix' => 'api/tag',
        'middleware' => ['auth:api', 'ceklevel:admin']
    ],
    function () use ($router) {
        $router->get('/', 'TagController@index');
        $router->post('/create', 'TagController@create');
        $router->post('/update/{id}', 'TagController@update');
        $router->delete('/delete', 'TagController@destroy');
    }
);
