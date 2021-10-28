<?php

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group([
    'prefix' => 'api'
], function () use ($router) {
    $router->post('register', 'AuthController@register');
    $router->post('login', 'AuthController@login');
    $router->get('profil', 'AuthController@profil');

    $router->get('category', 'CategoryController@index');
    $router->post('category/create', 'CategoryController@create');
    $router->post('category/update/{id}', 'CategoryController@update');
    $router->delete('category/delete', 'CategoryController@destroy');
});
