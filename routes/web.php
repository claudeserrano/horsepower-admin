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
use mikehaertl\pdftk\Pdf;

Route::get('/', function (Request $request) {
    return redirect('home');
});

Route::get('/home', function (Request $request) {
	if(!$request->session()->has('reg'))
		session(['reg' => '1']);
	if(!$request->session()->has('bf'))
		session(['bf' => '1']);
    return view('home');
})->name('home');

Route::get('/files', function(Request $request){
	return view('files');
});

Route::get('/reg/{lang}', function (Request $request, $lang) {
	if($request->session()->has('reg') && session('reg') < 1){
		return redirect('home');
	}
    return view($lang . '.registration');
});

Route::get('/bf/{lang}', function (Request $request, $lang) {
	if($request->session()->has('bf') && session('bf') < 1){
		return redirect('home');
	}
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

Route::post('/regpdf', function (Request $request) {

	// $request->validate([
 //        'Name' => 'required',
 //        'SSN1' => 'required|size:3',
 //        'SSN2' => 'required|size:2',
 //        'SSN3' => 'required|size:4',
 //        'Address1' => 'required',
 //        'City' => 'required',
 //        'State' => 'required',
 //        'Zip' => 'required',
 //        'AreaCode' => 'required|size:3',
 //        'TelNo1' => 'required|size:3',
 //        'TelNo2' => 'required|size:4',
 //        'AreaCodePhone' => 'required|size:3',
 //        'CellNo1' => 'required|size:3',
 //        'CellNo2' => 'required|size:4',
 //        'DOBMonth' => 'required|size:2',
 //        'DOBDay' => 'required|size:2',
 //        'DOBYear' => 'required|size:4',
 //        'Email' => 'required|email',
 //        'StartMonth' => 'required|size:2',
 //        'StartDay' => 'required|size:2',
 //        'StartYear' => 'required|size:4',
 //        'Classification' => 'required',
 //        'SchoolClass' => 'required',
 //    ]);

	$data_uri = $request->uri;
	$encoded_image = explode(",", $data_uri)[1];
	$decoded_image = base64_decode($encoded_image);

	$sig = @tempnam("/tmp", 'sig');
 	rename($sig, $sig .= '.png');

	$handle = fopen($sig, "w");
	fwrite($handle, $decoded_image);
	fclose($handle);

	$y = 265;

	$mobile = new App\Mobile_Detect();

	if($mobile->isMobile()){
		$y -= 10;
	}

	$pdf = new App\FPDF('P', 'mm', 'A4');
	$pdf->AddPage();
	$pdf->Image($sig,165,$y,-300);

	$sig = @tempnam("/tmp", 'sig');
 	rename($sig, $sig .= '.png');

	$handle = fopen($sig, "w");
	fwrite($handle, $pdf->output('S'));
	fclose($handle);

	// Storage::disk('s3')->put('signature.pdf', $pdf->Output('signature.pdf', 'S'));


	$pdf = file_get_contents('forms/Registration_English_Fillable.pdf');
	$fin = '';

	try {
		$pdftmp = @tempnam("/tmp", 'pdftmp');
	 	rename($pdftmp, $pdftmp .= '.pdf');

		$handle = fopen($pdftmp, "w");
		fwrite($handle, $pdf);
		fclose($handle);

		exec('pdftk '. $pdftmp .' stamp ' . $sig . ' output -', $output);

		foreach($output as $out){
			$fin .= (string) $out . "\n";
		}

		$handle = fopen($pdftmp, "w");
		fwrite($handle, $fin);
		fclose($handle);

	} catch (Exception $e) {
		return $e; 
	}

	$data = $request->all();
	unset($data['_token']);

	$data = toFDF($data);

	$fdf = @tempnam("/tmp", 'fdf');
	 	rename($fdf, $fdf .= '.pdf');

		$handle = fopen($fdf, "w");
		fwrite($handle, $data);
		fclose($handle);

	exec("pdftk ". $pdftmp ." fill_form ". $fdf . " output " . sys_get_temp_dir() . "\something.pdf flatten", $out);

	// $las = "";
	// foreach($out as $sin){
	// 	$las .= (string) $sin . "\n";
	// }

	return sys_get_temp_dir() . "\something.pdf";

	// $pdf->stamp(Storage::disk('s3')->url('signature.pdf'));

	// $pdf->flatten();

	// Storage::disk('s3')->delete('signature.pdf');

	// $temp = file_get_contents( (string) $pdf->getTmpFile() );

	// Storage::disk('s3')->put('final.pdf', $temp);

	return;

	$fpdf = Storage::disk('s3')->url('final.pdf');

	// Mail::raw('New application from ' . $data['Name'], function($message) use($pdf)
	// {
	// 	$message->subject('Horsepower - Request for Employee Registration');
	// 	$message->to('claudempserrano@gmail.com');
	// 	$message->from('no-reply@horsepowernyc.com', 'Horsepower Electric');
	// 	$message->attach($fpdf);
	// });

	return "Done";

	// Storage::disk('s3')->delete('final.pdf');

	// $request->session()->put('reg', 0);

	// return redirect('home');

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