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

$router->get('/', 'HomeController@welcome');
$router->get('/products', 'ProductsController@list');

/** Routes that requires authentication */
$router->group(['middleware' => 'auth'], function () use ($router) {
    $router->put('/orders', 'OrdersController@new');

    $router->group(['middleware' => 'admin'], function () use ($router) {
        $router->put('/products', 'ProductsController@add');
        $router->post('/products/{id}', 'ProductsController@update');
        $router->delete('/products/{id}', 'ProductsController@remove');

        $router->post('/orders/{id}/accept', 'OrdersController@accept');
        $router->get('/orders/{status}', 'OrdersController@list');
    });
});
