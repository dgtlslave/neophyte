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
Route::post('/deleteGroup', 'GroupController@deleteGroup');
Route::get('/aspirant/{aspirant}', 'AspirantController@viewAspirant');
Route::get('/getAllTask', 'TaskController@getAllTask');
Route::get('/viewResultTable', 'ResultTable@viewResultTable');
Route::post('/getAllSubtask', 'SubTaskController@getAllSubtask');
Route::post('/saveResult', 'AspirantController@saveResult');
Route::post('/getCurrentSubTaskResult', 'AspirantController@getCurrentSubTaskResult');
Route::post('/update', 'AspirantController@update');
Route::post('/updateBar', 'HomeController@updateBar');
Route::post('/bar', 'HomeController@bar');
Route::get('/report/{group}', 'ReportController@viewReport');
Route::post('/getAllAspirantReport', 'ReportController@getAllAspirantReport');
Route::post('/reportTaskFun', 'ReportController@reportTaskFun');
Route::post('/reportSubTaskFun', 'ReportController@reportSubTaskFun');
Route::post('/queryRun', 'ReportController@queryRun');

// Route::get('/update', 'ChartController@viewChart');
// Route::get('/getCurrentGroup')
