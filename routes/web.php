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

	// return \App\Services\Ultipro::login();
	        
			$curl = curl_init();

	        curl_setopt_array($curl, array(
	          CURLOPT_URL => "https://service4.ultipro.com/services/LoginService",
	          CURLOPT_RETURNTRANSFER => true,
	          CURLOPT_ENCODING => "",
	          CURLOPT_MAXREDIRS => 10,
	          CURLOPT_TIMEOUT => 30,
	          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	          CURLOPT_CUSTOMREQUEST => "POST",
	          CURLOPT_POSTFIELDS => "<s:Envelope xmlns:s=\"http://www.w3.org/2003/05/soap-envelope\" xmlns:a=\"http://www.w3.org/2005/08/addressing\">\r\n  <s:Header>\r\n<a:Action   s:mustUnderstand=\"1\">http://www.ultipro.com/services/loginservice/ILoginService/Authenticate</a:Action> \r\n  \t    <h:ClientAccessKey xmlns:h=\"http://www.ultipro.com/services/loginservice\">4CNBB</h:ClientAccessKey> \r\n  \t    <h:Password xmlns:h=\"http://www.ultipro.com/services/loginservice\">Wireless1!</h:Password> \r\n  \t    <h:UserAccessKey xmlns:h=\"http://www.ultipro.com/services/loginservice\">BVWFOG0000K0</h:UserAccessKey> \r\n  \t    <h:UserName xmlns:h=\"http://www.ultipro.com/services/loginservice\">trialservice</h:UserName> \r\n \t  </s:Header>\r\n  <s:Body>\r\n \t    <TokenRequest xmlns=\"http://www.ultipro.com/contracts\" /> \r\n  </s:Body>\r\n</s:Envelope>",
	          CURLOPT_HTTPHEADER => array(
	            "cache-control: no-cache",
	            "content-type: application/soap+xml; charset=utf-8",
	            "postman-token: 6366dbfa-8487-3b6a-f3d3-404e77fa8eaf"
	          ),
	        ));

	        try {

	            $response = curl_exec($curl);
	            $err = curl_error($curl);

	            curl_close($curl);

	            if ($err) {
	              return "cURL Error #:" . $err;
	            }

	            $xml = simplexml_load_string($response);
	            $token = $xml->children('s', true)->Body->children('http://www.ultipro.com/contracts')->children('http://www.ultipro.com/services/loginservice')->Token;
	            
	            return $token;

	        } catch (Exception $e) {
	            return $e;
	        }
});

Route::get('/success', function(){
	return view('success');
})->name('success');