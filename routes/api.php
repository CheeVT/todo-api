<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', 'UserController@register');
Route::post('/login', 'UserController@login');

Route::middleware('jwt')->get('/tasks', 'TaskController@index');
Route::middleware('jwt')->post('/tasks', 'TaskController@store');
Route::middleware('jwt')->put('/tasks/{id}', 'TaskController@update');
Route::middleware('jwt')->delete('/tasks/{id}', 'TaskController@delete');