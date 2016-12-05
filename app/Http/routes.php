<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::auth();

Route::get('/', 'HomeController@index');
Route::get('/contacts', 'HomeController@getContact');
Route::get('/portfolio', 'HomeController@getPortfolio');
Route::get('/getBreed/{id}', 'HomeController@getBreed');
Route::get('/getBreedPort/{id}', 'HomeController@getBreedPort');
Route::get('/getAnimals', 'HomeController@getAnimals');
Route::get('/getAnimalsBySpecies/{id}', 'HomeController@getAnimalsBySpecies');
Route::get('/getAnimalsByBreed/{sId}/{bId}', 'HomeController@getAnimalsByBreed');
Route::get('/checkoutCircle/{center}/{radius}/{sId}/{bId}', 'HomeController@checkoutCircle');
Route::get('/checkoutPolygon/{vertexes}/{sId}/{bId}', 'HomeController@checkoutPolygon');
Route::post('/store','AnimalsController@store');
Route::get('/search','HomeController@search');