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
        $router->get('users', 'AuthController@index');
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

## Post Router
$router->group(
    [
        'prefix' => 'api/post',
        'middleware' => ['auth:api', 'ceklevel:blogger,admin']
    ],
    function () use ($router) {
        $router->get('/', 'PostController@index');
        $router->post('/create', 'PostController@create');
        $router->post('/update/{id}', 'PostController@update');
        $router->delete('/delete', 'PostController@destroy');
    }
);

## Tripay Router
$router->group(
    [
        'prefix' => 'api/tripay'
    ],
    function () use ($router) {
        $router->get('/', 'TripayController@index');
        $router->post('/store', 'TripayController@store');
    }
);
