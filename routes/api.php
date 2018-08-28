<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('login', 'Api\AuthController@login');

Route::group(['middleware' => 'auth:api'], function () {

    Route::post('logout', 'Api\AuthController@logout');
    Route::post('logoutAll', 'Api\AuthController@logoutAll');

    // Gestion de usuarios
    Route::get('user', 'Api\UserController@index');
    Route::get('user/{user}', 'Api\UserController@show');
    Route::get('user-profile', 'Api\UserController@profile');
    Route::put('user-profile', 'Api\UserController@updateProfile');

    // Gestion de usuarios para administradores
    Route::group(['middleware' => 'can:admin'], function () {
        Route::post('register', 'Api\AuthController@register');
        Route::delete('user/{user}', 'Api\UserController@destroy');
        Route::put('user/{user}', 'Api\UserController@update');
        Route::put('user/{user}/role', 'Api\UserController@cambiarRol');
    });

    // Gestion de proyectos
    Route::get('proyecto', 'Api\ProyectoController@index');
    Route::get('proyecto-todos', 'Api\ProyectoController@indexAll');
    Route::get('proyecto/{proyecto}', 'Api\ProyectoController@show');
    Route::post('proyecto', 'Api\ProyectoController@store');

    // Gestion de proyectos para administradores y líderes de los proyectos
    Route::group(['middleware' => 'can:gestionar-proyectos', 'user'], function () {
        Route::put('proyecto', 'Api\ProyectoController@update');
        Route::delete('proyecto', 'Api\ProyectoController@destroy');
    });
});




