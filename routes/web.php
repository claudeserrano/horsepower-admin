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

Route::get('/', 'UsersController@index')->name('home');
Route::get('/error', 'UsersController@getErrorView')->name('error');

Route::post('/validate/key', 'UsersController@validateKey')->name('validate');
Route::get('/token/{id}/{token}', 'UsersController@getValidateView')->name('validateview');

Route::get('/admin/generate/', 'UsersController@getGenerateView');
Route::post('/admin/generate/key', 'UsersController@generateKey')->name('generate');
Route::get('/admin/employees/new', 'UsersController@getNewEmployeesView')->name('getnewview');
Route::get('/admin/employees/get', 'UsersController@getNewEmployees')->name('getnew');

Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
Route::get('/files', 'DashboardController@files')->name('files');

Route::get('/reg/{lang}', 'DashboardController@registration')->name('reg_emp');
Route::get('/bf/{lang}', 'DashboardController@bf')->name('build_trade');
Route::post('/regpdf/{lang}', 'DashboardController@sendReg')->name('regpdf');
Route::post('/bfpdf/{lang}', 'DashboardController@sendBF')->name('bfpdf');
Route::post('/upload', 'DashboardController@uploadFiles')->name('upload');

Route::get('/success', function(){
	return view('success');
})->name('success');