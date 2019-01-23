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
// Route::get('/drive', function(){ return redirect()->to(getenv('DRIVE_URL')); });

//-----------------------------------------------------------------------------------//

Route::prefix('admin')->group(function(){
	// Route::get('/', 'AdminController@index');
	Route::get('/exam/results', 'AdminController@getExamResults');
	Route::get('/exam/results/{id}', 'AdminController@getEmployeeResults');
	Route::get('/form/list', 'AdminController@getNewHireList');
	Route::get('/form/data/{id}', 'AdminController@getNewHireData');
	Route::get('/form/data/{id}/generate', 'AdminController@generateData');
});

// Route::get('/admin/employees/new', 'UsersController@getNewEmployeesView')->name('getnewview');
// Route::get('/admin/employees/get', 'UsersController@getNewEmployees')->name('getnew');


//-----------------------------------------------------------------------------------//

Route::prefix('exam')->group(function(){
	Route::get('/', 'ExamController@index');
	Route::post('/submit', 'ExamController@submit')->name('submitExam');
	Route::post('/start', 'ExamController@start')->name('startExam');
	Route::get('/generate', 'ExamController@generate')->name('generate');
	Route::get('/resume', 'ExamController@resume')->name('resumeExam');
	Route::get('/complete', 'ExamController@complete');
	Route::get('/flush', 'ExamController@flush');
});

//-----------------------------------------------------------------------------------//

/*
Route::prefix('form')->group(function(){
	Route::get('/', 'FormController@index');
	Route::get('/flush', 'FormController@flush');
	// Route::get('/resume/{id}', 'FormController@resume');
	Route::post('/submit', 'FormController@submit')->name('submitForm');
	Route::get('/lang/{lang}', 'FormController@changeLanguage');
});
*/

//-----------------------------------------------------------------------------------//

// Route::post('/validate/key', 'UsersController@validateKey')->name('validate');
// Route::get('/validate/key/query', 'UsersController@validateKey')->name('queryvalidate');
// Route::get('/token/{id}/{token}', 'UsersController@getValidateView')->name('validateview');

// Route::get('/generate/', 'UsersController@getGenerateView');
// Route::post('/generate/key', 'UsersController@generateKey')->name('generate');

// Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
// Route::get('/files', 'DashboardController@files')->name('files');

// Route::get('/reg/{lang}', 'DashboardController@registration')->name('reg_emp');
// Route::get('/bf/{lang}', 'DashboardController@bf')->name('build_trade');
// Route::get('/union', 'DashboardController@union')->name('union');

// Route::post('/regpdf/{lang}', 'DashboardController@sendReg')->name('regpdf');
// Route::post('/bfpdf/{lang}', 'DashboardController@sendBF')->name('bfpdf');
// Route::post('/union/send', 'DashboardController@sendUnion')->name('sendunion');
// Route::post('/upload', 'DashboardController@uploadFiles')->name('upload');

Route::get('/success', function(){
	return view('success');
})->name('success');