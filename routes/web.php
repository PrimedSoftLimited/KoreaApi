<?php

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


$router->post('api/register','RegisterController@store');

$router->post('api/login','LoginController@login');

$router->post('api/goals/create','GoalController@store');

$router->put('api/goals/{gid}/update','GoalController@update');

$router->get('api/profile', 'UserController@profile');

$router->get('api/goals', 'GoalController@index');

$router->get('api/goals/{gid}', 'GoalController@show');

$router->get('api/goals/{gid}/edit', 'GoalController@edit');

$router->delete('api/goals/{gid}/delete', 'GoalController@destroy');


$router->get('/key', function() {
    return str_random(32);
});
