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

Route::middleware(['horsepower'])->group(function () {
    
});

Route::get('/', 'UsersController@index')->name('home');
Route::get('/token/{id}/{token}', 'UsersController@index');

Route::get('/auth', 'UsersController@index')->name('auth');
Route::post('/validate/key', 'UsersController@validateKey')->name('validate');

Route::get('/admin/generate/', 'UsersController@getGenerateView');
Route::post('/admin/generate/key', 'UsersController@generateKey')->name('generate');

Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
Route::get('/files', 'DashboardController@files');

Route::get('/reg/{lang}', 'DashboardController@registration');
Route::get('/bf/{lang}', 'DashboardController@bf');
Route::post('/regpdf/{lang}', 'DashboardController@sendReg')->name('regpdf');
Route::post('/bfpdf/{lang}', 'DashboardController@sendBF')->name('bfpdf');

Route::post('/upload', function(Request $request){

	$folder_name = "300667";
	$folder = checkDrive('300667');

	if($folder == false){
		if(Storage::disk('google')->createDir($folder_name))
			$folder = checkDrive($folder_name);
	}

	$path = $folder['path'] . "/";

	//	Government Issued ID
	Storage::disk('google')->put($path . 'GOVID.'.pathinfo($_FILES["id"]["name"], PATHINFO_EXTENSION), file_get_contents($_FILES["id"]["tmp_name"]));

	Storage::disk('google')->put($path . 'GREENCARD.'.pathinfo($_FILES["greencard"]["name"], PATHINFO_EXTENSION), file_get_contents($_FILES["greencard"]["tmp_name"]));

	Storage::disk('google')->put($path . 'SSN.'.pathinfo($_FILES["ssn"]["name"], PATHINFO_EXTENSION), file_get_contents($_FILES["ssn"]["tmp_name"]));

	Storage::disk('google')->put($path . 'DD.'.pathinfo($_FILES["dd"]["name"], PATHINFO_EXTENSION), file_get_contents($_FILES["dd"]["tmp_name"]));


	// 	if (move_uploaded_file($_FILES["id"]["tmp_name"], $dir . '/ID.' . pathinfo($_FILES["id"]["name"], PATHINFO_EXTENSION)))
	//         echo "Your files have been uploaded.";
	//     else
	//         echo "Sorry, there was an error uploading your file.";

 //    //	Green Card

	//     if (move_uploaded_file($_FILES["greencard"]["tmp_name"], $dir . '/GCARD.' . pathinfo($_FILES["greencard"]["name"], PATHINFO_EXTENSION)))
	//         echo "Your files have been uploaded.";
	//     else
	//         echo "Sorry, there was an error uploading your file.";

 //    //	SSN

	//     if (move_uploaded_file($_FILES["ssn"]["tmp_name"], $dir . '/SSN.' . pathinfo($_FILES["ssn"]["name"], PATHINFO_EXTENSION)))
	//         echo "Your files have been uploaded.";
	//     else
	//         echo "Sorry, there was an error uploading your file.";

 //    //	Direct Deposit

	//     if (move_uploaded_file($_FILES["dd"]["tmp_name"], $dir . '/DD.' . pathinfo($_FILES["dd"]["name"], PATHINFO_EXTENSION)))
	//         echo "Your files have been uploaded.";
	//     else
	//         echo "Sorry, there was an error uploading your file.";

    //	Certifications


    return redirect()->route('dashboard');
})->name('upload');


function checkDrive($filename){
	foreach(Storage::disk('google')->listContents() as $item){
		if(!strcmp($item['filename'], $filename))
			return $item;
	}
	return false;
}

function toFDF($arr){
	$header = "%FDF-1.2 \n
		1 0 obj<</FDF<< /Fields[ \n";
	$footer = "] >> >> \n
		endobj \n
		trailer \n
		<</Root 1 0 R>> \n
		%%EOF";

	$fdf = "";
	foreach($arr as $key=>$value){
		$fdf .= "<< /T (" . $key . ") /V (" . $value . ") >>\n";
	}

	return $header . $fdf . $footer;
}

Route::get('/success', function(){
	return view('success');
})->name('success');