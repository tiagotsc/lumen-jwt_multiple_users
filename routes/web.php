<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'api/v1/user'], function () use ($router) {

    $router->post('login', 'AuthJWTController@login');

    $router->group(['middleware' => 'auth:api'], function () use ($router) {
        $router->post('logout', 'AuthJWTController@logout');
        $router->post('refresh', 'AuthJWTController@refresh');
        $router->post('profile', 'AuthJWTController@profile');
    });
    
});

$router->group(['prefix' => 'api/v1/admin', 'middleware' => ['assign.guard:admin']], function () use ($router) {

    $router->post('login', 'AuthJWTController@login');

    $router->group(['middleware' => ['jwt.auth']], function () use ($router) {

        $router->post('logout', 'AuthJWTController@logout');
        $router->post('refresh', 'AuthJWTController@refresh');
        $router->post('profile', 'AuthJWTController@profile');
        
    });
    
});
