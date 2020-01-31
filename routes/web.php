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






$router->group(['prefix' => 'auth'], function() use ($router){
	//mathces api register
    $router->post('/register', 'AuthController@register');
    $router->post('/login', 'AuthController@login');
});

$router->group(['middleware' => ['auth']], function ($router){
	$router->get('/books', 'BooksController@index');
    $router->post('/books', 'BooksController@store');
    $router->get('/books/{id}', 'BooksController@show');
    $router->put('/books/{id}', 'BooksController@update');
    $router->delete('/books/{id}', 'BooksController@destroy');
    $router->get('/books/mybooks/{userId}', 'BooksController@myBook');

    //Routes table categories
    $router->get('/categories/books', 'CategoriesController@index');
    $router->post('/categories/books', 'CategoriesController@store');
    $router->get('/categories/books/{id}', 'CategoriesController@show');
    $router->put('/categories/books/{id}', 'CategoriesController@update');
    $router->delete('/categories/books/{id}', 'CategoriesController@destroy');

    //profiles table
    $router->post('/user/profiles', 'ProfilesController@store');
    $router->get('/user/profiles/{userId}', 'ProfilesController@show');
    $router->get('/user/profiles/image/{imageName}', 'ProfilesController@image');

    //Transactions Table
    $router->get('/transactions', 'TransactionsCotroller@index');
    $router->post('/transactions', 'TransactionsCotroller@store');
    $router->get('/transactions/{id}', 'TransactionsCotroller@show');
});
