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
$router->get('/authors','AuthorController@index' );
$router->post('/authors','AuthorController@store' );
$router->get('/authors/{id}','AuthorController@show' );
$router->patch('/authors/{id}','AuthorController@update' );
$router->delete('/authors/{id}','AuthorController@destroy' );
