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

$app->get('/', function () use ($app) {
    return $app->version();
});
$app->get('comments', ['middleware' => 'auth', 'uses' => 'CommentsController@getAll']);
$app->get('comments/{id}', [ 'uses' => 'CommentsController@get']);
$app->post('comments', ['middleware' => 'auth', 'uses' => 'CommentsController@create']);
$app->put('comments/{id}', ['middleware' => 'auth', 'uses' => 'CommentsController@update']);
$app->delete('comments/{id}', ['middleware' => 'auth', 'uses' => 'CommentsController@delete']);
