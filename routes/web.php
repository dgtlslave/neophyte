<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::post('/saveGroup', 'HomeController@saveGroup');
Route::get('/getAllGroup', 'HomeController@getAllGroup');
Route::get('/group/{group}', 'GroupController@viewGroup');
Route::post('/createAspirant', 'GroupController@createAspirant');
Route::post('/getAllAspirant', 'GroupController@getAllAspirant');
Route::get('/aspirant/{aspirant}', 'AspirantController@viewAspirant');
Route::get('/getAllTask', 'TaskController@getAllTask');
// Route::get('/getCurrentGroup')
