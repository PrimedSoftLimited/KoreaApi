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

//Login and Register Route
$router->post('api/register','RegisterController@store');

$router->post('api/login','LoginController@login');

//User Profile Route
$router->get('api/profile', 'UserController@profile');

//Goals Route
$router->post('api/goals/create','GoalController@store');

$router->put('api/goals/{gid}/update','GoalController@update');

$router->get('api/goals', 'GoalController@index');

$router->get('api/goals/{gid}', 'GoalController@show');

$router->get('api/goals/{gid}/edit', 'GoalController@edit');

$router->delete('api/goals/{gid}/delete', 'GoalController@destroy');

//Task Routes
$router->get('api/goals/{gid}/tasks', 'TaskController@showAll');

$router->post('api/goals/{gid}/createtask','TaskController@store');

$router->get('api/goals/{gid}/tasks/{tid}/edit','TaskController@edit');

$router->put('api/goals/{gid}/tasks/{tid}/update','TaskController@update');

$router->put('api/goals/{gid}/tasks/{tid}/completed','TaskController@completetask');

$router->put('api/goals/{gid}/tasks/{tid}/uncomplete','TaskController@uncompletetask');

$router->delete('api/goals/{gid}/tasks/{tid}/delete','TaskController@destroy');

$router->get('/key', function() {
    return str_random(32);
});
