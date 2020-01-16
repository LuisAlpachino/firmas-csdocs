<?php
use Illuminate\Support\Str;
/*
|--------------------------------------------------------------------------
| Application Routes
|------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

/** @var TYPE_NAME $router */

$router->get('/', function () use ($router) {
    return "Efirmas-csdocs";
});

$router->get('/key', function () use ($router){
   return  base64_encode(Str::random(32));
});

//Rutas para CRUD USERS
$router->group(['prefix' => 'user', 'middleware' => ['auth']], function() use ($router){
   //url "/user/"
    $router->post('setUser','UserController@setUser');
    $router->post('login', 'UserController@getToken');
    $router->get('getUsers', 'UserController@getUsers');
    $router->get('getUsers/{id}', 'UserController@getUserById');
    $router->put('update/{id}', 'UserController@updateById');
    $router->delete('delete/{id}', 'UserController@deleteById');
});

//Rutas para CRUD DOCUMENTS
$router->group(['prefix' => 'documents'], function() use ($router){
    //url "/documents/"
    $router->post('insert','DocumentController@insert');
    $router->get('getDocuments', 'DocumentController@getDocuments');
    $router->get('getDocuments/{id}', 'DocumentController@getDocumentById');
    $router->put('update/{id}', 'DocumentController@updateById');
    $router->delete('delete/{id}', 'DocumentController@deleteById');

});

//Apis Externas
$router->group(['prefix' => 'api'], function() use ($router){
    //url "/api/"
    $router->get('rfc/{id}','ApisExternaController@rfc');
    $router->get('cp/{id}','ApisExternaController@cp');
});




