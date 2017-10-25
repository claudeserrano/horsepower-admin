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
Route::get('/files', 'DashboardController@files');

Route::get('/reg/{lang}', 'DashboardController@registration');
Route::get('/bf/{lang}', 'DashboardController@bf');
Route::post('/regpdf/{lang}', 'DashboardController@sendReg')->name('regpdf');
Route::post('/bfpdf/{lang}', 'DashboardController@sendBF')->name('bfpdf');
Route::post('/upload', 'DashboardController@uploadFiles')->name('upload');

Route::get('/ultipro/login', function(){

	$LOGIN_URL = 'https://service4.ultipro.com/services/LoginService';
	 $client = new \SoapClient($LOGIN_URL, array('soap_version' => SOAP_1_2, 'exceptions' => TRUE, 'trace' => TRUE));

    $headers = array();
    $headers[0] = new \SoapHeader('http://www.w3.org/2005/08/addressing', 'Action', 'http://www.ultipro.com/services/loginservice/ILoginService/Authenticate', true);
    $headers[1] = new \SoapHeader('http://www.ultipro.com/services/loginservice', 'ClientAccessKey', getenv('ULTIPRO_CKEY'));
	$headers[2] = new \SoapHeader('http://www.ultipro.com/services/loginservice', 'Password', getenv('ULTIPRO_PW'));
	$headers[3] = new \SoapHeader('http://www.ultipro.com/services/loginservice', 'UserAccessKey', getenv('ULTIPRO_UKEY'));
    $headers[4] = new \SoapHeader('http://www.ultipro.com/services/loginservice', 'UserName', getenv('ULTIPRO_USER'));

    $client->__setSoapHeaders($headers);
	$response = $client->Authenticate();

	try {
		return $response->Token;
	} catch (Exception $e) {
		return $e;	
	}
	// return App\Services\Ultipro::login();
});

Route::get('/success', function(){
	return view('success');
})->name('success');