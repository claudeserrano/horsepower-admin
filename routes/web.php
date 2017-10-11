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
use Illuminate\Http\Request;

Route::get('/', function (Request $request) {
    return redirect('home');
});

Route::get('/home', function (Request $request) {
	if(!$request->session()->has('reg'))
		session(['reg' => '1']);
	if(!$request->session()->has('bf'))
		session(['bf' => '1']);
    return view('home');
});

// Route::get('/ultipro', function(Request $request){
// 	$vars = array();

// 	$ch = curl_init();
// 	curl_setopt($ch, CURLOPT_URL,"https://service2.ultipro.com/personnel/v1/employee-ids");
// 	curl_setopt($ch, CURLOPT_POST, 1);
// 	curl_setopt($ch, CURLOPT_POSTFIELDS,$vars);  //Post Fields
// 	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// 	$headers = [
// 	    'X-Apple-Tz: 0',
// 	    'X-Apple-Store-Front: 143444,12',
// 	    'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
// 	    'Accept-Encoding: gzip, deflate',
// 	    'Accept-Language: en-US,en;q=0.5',
// 	    'Cache-Control: no-cache',
// 	    'Content-Type: application/x-www-form-urlencoded; charset=utf-8',
// 	    'Host: www.example.com',
// 	    'Referer: http://www.example.com/index.php', //Your referrer address
// 	    'User-Agent: Mozilla/5.0 (X11; Ubuntu; Linux i686; rv:28.0) Gecko/20100101 Firefox/28.0',
// 	    'X-MicrosoftAjax: Delta=true'
// 	];

// 	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

// 	$server_output = curl_exec ($ch);

// 	curl_close ($ch);

// 	print  $server_output ;
// });

Route::get('/files', function(Request $request){
	return view('files');
});

Route::get('/reg/{lang}', function (Request $request, $lang) {
	if($request->session()->has('reg') && session('reg') < 1){
		return redirect('home');
	}

	exec("pdftk forms/Registration_". $lang ."_Fillable.pdf dump_data_fields > fields.txt");
	copy("forms/Registration_". $lang ."_Fillable.pdf", "Form.pdf");
    return view($lang . '.registration');
});

Route::get('/bf/{lang}', function (Request $request, $lang) {
	if($request->session()->has('bf') && session('bf') < 1){
		return redirect('home');
	}

	exec("pdftk forms/BF_". $lang ."_Fillable.pdf dump_data_fields > fields.txt");
	copy("forms/BF_". $lang ."_Fillable.pdf", "Form.pdf");
    return view($lang . '.bf');
});

Route::post('/upload', function(Request $request){
	$dir = 'empfiles/300667';

	if(!file_exists($dir))
		mkdir($dir);

	//	Government Issued ID

		if (move_uploaded_file($_FILES["id"]["tmp_name"], $dir . '/ID.' . pathinfo($_FILES["id"]["name"], PATHINFO_EXTENSION)))
	        echo "Your files have been uploaded.";
	    else
	        echo "Sorry, there was an error uploading your file.";

    //	Green Card

	    if (move_uploaded_file($_FILES["greencard"]["tmp_name"], $dir . '/GCARD.' . pathinfo($_FILES["greencard"]["name"], PATHINFO_EXTENSION)))
	        echo "Your files have been uploaded.";
	    else
	        echo "Sorry, there was an error uploading your file.";

    //	SSN

	    if (move_uploaded_file($_FILES["ssn"]["tmp_name"], $dir . '/SSN.' . pathinfo($_FILES["ssn"]["name"], PATHINFO_EXTENSION)))
	        echo "Your files have been uploaded.";
	    else
	        echo "Sorry, there was an error uploading your file.";

    //	Direct Deposit

	    if (move_uploaded_file($_FILES["dd"]["tmp_name"], $dir . '/DD.' . pathinfo($_FILES["dd"]["name"], PATHINFO_EXTENSION)))
	        echo "Your files have been uploaded.";
	    else
	        echo "Sorry, there was an error uploading your file.";

    //	Certifications


    return redirect('home');
})->name('upload');

Route::post('/regpdf', function (Request $request) {

	$request->validate([
        'Name' => 'required',
        'SSN1' => 'required|size:3',
        'SSN2' => 'required|size:2',
        'SSN3' => 'required|size:4',
        'Address1' => 'required',
        'City' => 'required',
        'State' => 'required',
        'Zip' => 'required',
        'AreaCode' => 'required|size:3',
        'TelNo1' => 'required|size:3',
        'TelNo2' => 'required|size:4',
        'AreaCodePhone' => 'required|size:3',
        'CellNo1' => 'required|size:3',
        'CellNo2' => 'required|size:4',
        'DOBMonth' => 'required|size:2',
        'DOBDay' => 'required|size:2',
        'DOBYear' => 'required|size:4',
        'Email' => 'required|email',
        'StartMonth' => 'required|size:2',
        'StartDay' => 'required|size:2',
        'StartYear' => 'required|size:4',
        'Classification' => 'required',
        'SchoolClass' => 'required',
    ]);

	$data_uri = $request->uri;
	$encoded_image = explode(",", $data_uri)[1];
	$decoded_image = base64_decode($encoded_image);
	file_put_contents("signature.png", $decoded_image);

	$y = 265;

	$mobile = new App\Mobile_Detect();

	if($mobile->isMobile()){
		$y -= 10;
	}

	$pdf = new App\FPDF('P', 'mm', 'A4');
	$pdf->AddPage();
	$pdf->Image('signature.png',165,$y,-300);
	$pdf->Output('signature.pdf', 'F');

	unlink('signature.png');

	exec("pdftk Form.pdf stamp signature.pdf output Final.pdf");

	unlink('signature.pdf');

	$data = $request->all();
	unset($data['_token']);
	$pdf = new App\PdfForm('Final.pdf', $data);

	$pdf->flatten()->save('Final.pdf');

	Mail::raw('New application from ' . $data['Name'], function($message)
	{
		$message->subject('Horsepower - Request for Employee Registration');
		$message->to('claudempserrano@gmail.com');
		$message->from('no-reply@horsepowernyc.com', 'Horsepower Electric');
		$message->attach('Final.pdf');
	});

	unlink('Final.pdf');
	unlink('Form.pdf');

	$request->session()->put('reg', 0);

	return redirect('home');

})->name('regpdf');

Route::post('/bfpdf', function (Request $request) {

	$request->validate([
		'LAST_NAME' => 'required',
		'FIRST_NAME' => 'required',
		'SSN' => 'required|size:11',
		'NUMBER' => 'required|size:14',
		'DOB' => 'required|size:10|date_format:m/d/Y',
		'EMAIL' => 'required|email',
		'STREET_ADDRESS' => 'required',
		'CITY' => 'required',
		'STATE' => 'required',
		'ZIP' => 'required',
		'JOB_CLASS' => 'required',
		'DATE_HIRED' => 'required|date_format:m/d/Y',
		'FAMILY_DOB1' => 'nullable|date_format:m/d/Y',
		'FAMILY_DOB2' => 'nullable|date_format:m/d/Y',
		'FAMILY_DOB3' => 'nullable|date_format:m/d/Y',
		'FAMILY_DOB4' => 'nullable|date_format:m/d/Y',
		'FAMILY_DOB5' => 'nullable|date_format:m/d/Y',
		'FAMILY_DOB6' => 'nullable|date_format:m/d/Y',
		'FAMILY_DOB7' => 'nullable|date_format:m/d/Y',
		'FAMILY_DOB8' => 'nullable|date_format:m/d/Y',
		'DATE_MARRIED' => 'nullable|date_format:m/d/Y',
		'DATE_DIVORCE' => 'nullable|date_format:m/d/Y',
		'SPOUSE_DATE' => 'nullable|date_format:m/d/Y',
		'BENE_DOB1' => 'nullable|date_format:m/d/Y',
		'BENE_DOB2' => 'nullable|date_format:m/d/Y',
		'BENE_DOB3' => 'nullable|date_format:m/d/Y',
		'BENE_DOB4' => 'nullable|date_format:m/d/Y',
		'SPOUSE_EMPLOYER_NUMBER' => 'nullable|size:14',
		'FAMILY_SSN1' => 'nullable|size:11',
		'FAMILY_SSN2' => 'nullable|size:11',
		'FAMILY_SSN3' => 'nullable|size:11',
		'FAMILY_SSN4' => 'nullable|size:11',
		'FAMILY_SSN5' => 'nullable|size:11',
		'FAMILY_SSN6' => 'nullable|size:11',
		'FAMILY_SSN7' => 'nullable|size:11',
		'FAMILY_SSN8' => 'nullable|size:11',
		'BENE_SSN1' => 'nullable|size:11',
		'BENE_SSN2' => 'nullable|size:11',
		'BENE_SSN3' => 'nullable|size:11',
	]);

	if($request->lang > 0){
		$x = 107;
		$y = 240;
	}
	else{
		$x = 105;
		$y = 258;
	}

	$mobile = new App\Mobile_Detect();

	if($mobile->isMobile()){
		$x += 6;
		$y -= 14;
	}
	

	unset($request['lang']);

	$data_uri = $request->uri;
	$encoded_image = explode(",", $data_uri)[1];
	$decoded_image = base64_decode($encoded_image);
	file_put_contents("signature.png", $decoded_image);

	$pdf = new App\FPDF('P', 'mm', 'A4');
	$pdf->AddPage();
	$pdf->Image('signature.png',$x,$y,-300);
	$pdf->Output('signature.pdf', 'F');

	unlink('signature.png');

	exec("pdftk Form.pdf stamp signature.pdf output Final.pdf");

	unlink('signature.pdf');

	$data = $request->all();
	$data["DATE"] = date("m/d/Y");
	unset($data['_token']);
	$pdf = new App\PdfForm('Final.pdf', $data);

	$pdf->flatten()->save('Final.pdf');

	Mail::raw('New application from '. $data['FIRST_NAME'] . ' ' . $data['LAST_NAME'], function($message)
	{
		$message->subject('Horsepower - Building Trades Benefit Funds Enrollment');
		$message->to('claudempserrano@gmail.com');
		$message->from('no-reply@horsepowernyc.com', 'Horsepower Electric');
		$message->attach('Final.pdf');
	});

	unlink('Final.pdf');
	unlink('Form.pdf');

	$request->session()->put('bf', 0);

	return redirect('home');

})->name('bfpdf');

Route::get('/success', function(){
	return view('success');
})->name('success');