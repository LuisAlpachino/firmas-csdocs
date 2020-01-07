<?php

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
/*$router->get('/', function () use ($router) {
    return "Efirmas-csdocs";
});*/
// API route group estados
/*$router->group(['prefix' => 'estados'], function () use ($router) {
    // Matches "/api/estados

    $router->get('view','EstadosController@view');
   // $router->post('register', 'UsuariosController@create');
    $router->post('insert','EstadosController@insertStates');

    $router->get('view/{id}','EstadosController@viewid');

    $router->delete('delete/{id}','EstadosController@delete');

    $router->put('update/{id}','EstadosController@update');
});
*/
//Rutas para CRUD USERS
$router->group(['prefix' => 'user'], function() use ($router){
   //url "/user/"
    $router->post('insert','UserController@insert');
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



