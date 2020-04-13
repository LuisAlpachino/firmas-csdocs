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
   return  Str::random(32);
});

$router->post('login', 'UserController@getToken');
$router->post('createUser','UserController@createUser');
$router->get('getUsers/{id}', 'UserController@getUserById');
$router->put('update/{id}', 'UserController@updateById');
$router->delete('delete/{id}', 'UserController@deleteById');
$router->get('getUsers', 'UserController@getUsers');


//documentos iniciales
$router->get('obtenerFirma','DocumentController@upload');


//Catalogos
$router->post('estados','LocalidadesController@importEstados');
$router->post('municipios','LocalidadesController@importMunicipios');
$router->post('localidades','LocalidadesController@importLocalidades');

//rutas para Dirección
$router->group(['prefix' => 'addresses'], function () use($router){
    $router->get('getStates','LocalidadesController@getStates');
    $router->get('getMunicipalitiesById/{id}','LocalidadesController@getMunicipalitiesById');
    $router->get('getLocalitiesByCP/{id}','LocalidadesController@getLocalitiesByCP');
});


//Rutas para CRUD DOCUMENTS
$router->group(['prefix' => 'documents'], function() use ($router){
    //url "/documents/"
    $router->post('insert','DocumentController@insert');
    $router->get('getDocuments', 'DocumentController@getDocuments');
    $router->get('getDocuments/{id}', 'DocumentController@getDocumentById');
    $router->put('update/{id}', 'DocumentController@updateById');
    $router->delete('delete/{id}', 'DocumentController@deleteById');
    $router->get('getConstancia', 'DocumentController@getContancia');
});

//Apis Externas
$router->group(['prefix' => 'api'], function() use ($router){
    //url "/api/"
    $router->get('rfc/{id}','ApisExternaController@rfc');
    $router->get('cp/{id}','ApisExternaController@cp');
    $router->get('curp/{id}', 'ApisExternaController@curp');
});

//Rutas para CRUD USERS
$router->group(['middleware' => ['auth']], function() use ($router){
    //url "/user/"
});
//Vista


