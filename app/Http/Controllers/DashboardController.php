<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
	/**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
		if(!$request->session()->has('reg'))
			session(['reg' => '1']);
		if(!$request->session()->has('bf'))
			session(['bf' => '1']);
	    return view('dashboard');
    }

    public function registration(Request $request, $lang)
    {
        return view($lang . '/registration');
    }

    public function bf(Request $request, $lang)
    {
        return view($lang . '/bf');
    }
    
    public function files(Request $request)
    {
        return view('files');
    }

    /**
     * @param  \Illuminate\Http\Request 
     * @param  string
     * @return \Illuminate\Http\Response
     */
    public function sendReg(Request $request, $lang) 
    {

        // $request->validate([
        //     'Name' => 'required',
        //     'SSN1' => 'required|size:3',
        //     'SSN2' => 'required|size:2',
        //     'SSN3' => 'required|size:4',
        //     'Address1' => 'required',
        //     'City' => 'required',
        //     'State' => 'required',
        //     'Zip' => 'required',
        //     'AreaCode' => 'required|size:3',
        //     'TelNo1' => 'required|size:3',
        //     'TelNo2' => 'required|size:4',
        //     'AreaCodePhone' => 'required|size:3',
        //     'CellNo1' => 'required|size:3',
        //     'CellNo2' => 'required|size:4',
        //     'DOBMonth' => 'required|size:2',
        //     'DOBDay' => 'required|size:2',
        //     'DOBYear' => 'required|size:4',
        //     'Email' => 'required|email',
        //     'StartMonth' => 'required|size:2',
        //     'StartDay' => 'required|size:2',
        //     'StartYear' => 'required|size:4',
        //     'Classification' => 'required',
        //     'SchoolClass' => 'required',
        // ]);

        //  File paths
        $tmp = env('TMP_PATH', 'tmp/');
        $sig = $tmp . 'sig.png';
        $sigpdf = $tmp . 'sig.pdf';
        $pdftmp = $tmp . 'form.pdf';
        $first = $tmp . 'first.pdf';
        $fdf = $tmp . 'fdf.pdf';

        //  Signature image processing
        $data_uri = $request->uri;
        $encoded_image = explode(",", $data_uri)[1];
        $decoded_image = base64_decode($encoded_image);

        //  Copying image to tmp file
        file_put_contents($sig, $decoded_image);

        $y = 265;

        //  Check if using mobile
        $mobile = new \App\Services\Mobile_Detect();
        if($mobile->isMobile()){
            $y -= 10;
        }

        //  Creating signature PDF file
        $pdf = new \App\Services\FPDF('P', 'mm', 'A4');
        $pdf->AddPage();
        $pdf->Image($sig,165,$y,-300);
        file_put_contents($sigpdf, $pdf->output('S'));

        $pdf = file_get_contents('forms/Registration_'.$lang.'_Fillable.pdf');

        try {
            file_put_contents($pdftmp, $pdf);

            //  Stamp signature to PDF
            exec(getenv('LIB_PATH', '') . 'pdftk '. $pdftmp .' stamp ' . $sigpdf . ' output ' . $first);

        } catch (Exception $e) {
            return $e; 
        }

        $data = $request->all();
        unset($data['_token']);

        //  Create FDF file for filling up form
        $dfdf = toFDF($data);
        file_put_contents($fdf, $dfdf);

        //  Fill up form with signature & flatten file to remove editing
        exec(getenv('LIB_PATH', '') . 'pdftk '. $first .' fill_form '. $fdf . ' output tmp/final.pdf flatten');

        \Mail::raw('New application from ' . $data['Name'], function($message)
        {
            $message->subject('Horsepower - Request for Employee Registration');
            $message->to('claudempserrano@gmail.com');
            $message->from('no-reply@horsepowernyc.com', 'Horsepower Electric');
            $message->attach('tmp/final.pdf');
        });

        $request->session()->put('reg', 0);

        return redirect('dashboard');

    }

    public function sendBF(Request $request, $lang)
    {
        
        // $request->validate([
        //  'LAST_NAME' => 'required',
        //  'FIRST_NAME' => 'required',
        //  'SSN' => 'required|size:11',
        //  'NUMBER' => 'required|size:14',
        //  'DOB' => 'required|size:10|date_format:m/d/Y',
        //  'EMAIL' => 'required|email',
        //  'STREET_ADDRESS' => 'required',
        //  'CITY' => 'required',
        //  'STATE' => 'required',
        //  'ZIP' => 'required',
        //  'JOB_CLASS' => 'required',
        //  'DATE_HIRED' => 'required|date_format:m/d/Y',
        //  'FAMILY_DOB1' => 'nullable|date_format:m/d/Y',
        //  'FAMILY_DOB2' => 'nullable|date_format:m/d/Y',
        //  'FAMILY_DOB3' => 'nullable|date_format:m/d/Y',
        //  'FAMILY_DOB4' => 'nullable|date_format:m/d/Y',
        //  'FAMILY_DOB5' => 'nullable|date_format:m/d/Y',
        //  'FAMILY_DOB6' => 'nullable|date_format:m/d/Y',
        //  'FAMILY_DOB7' => 'nullable|date_format:m/d/Y',
        //  'FAMILY_DOB8' => 'nullable|date_format:m/d/Y',
        //  'DATE_MARRIED' => 'nullable|date_format:m/d/Y',
        //  'DATE_DIVORCE' => 'nullable|date_format:m/d/Y',
        //  'SPOUSE_DATE' => 'nullable|date_format:m/d/Y',
        //  'BENE_DOB1' => 'nullable|date_format:m/d/Y',
        //  'BENE_DOB2' => 'nullable|date_format:m/d/Y',
        //  'BENE_DOB3' => 'nullable|date_format:m/d/Y',
        //  'BENE_DOB4' => 'nullable|date_format:m/d/Y',
        //  'SPOUSE_EMPLOYER_NUMBER' => 'nullable|size:14',
        //  'FAMILY_SSN1' => 'nullable|size:11',
        //  'FAMILY_SSN2' => 'nullable|size:11',
        //  'FAMILY_SSN3' => 'nullable|size:11',
        //  'FAMILY_SSN4' => 'nullable|size:11',
        //  'FAMILY_SSN5' => 'nullable|size:11',
        //  'FAMILY_SSN6' => 'nullable|size:11',
        //  'FAMILY_SSN7' => 'nullable|size:11',
        //  'FAMILY_SSN8' => 'nullable|size:11',
        //  'BENE_SSN1' => 'nullable|size:11',
        //  'BENE_SSN2' => 'nullable|size:11',
        //  'BENE_SSN3' => 'nullable|size:11',
        // ]);

        //  File paths
        $tmp = env('TMP_PATH', 'tmp/');
        $sig = $tmp . 'sig.png';
        $sigpdf = $tmp . 'sig.pdf';
        $pdftmp = $tmp . 'form.pdf';
        $first = $tmp . 'first.pdf';
        $fdf = $tmp . 'fdf.pdf';

        //  Signature image processing
        $data_uri = $request->uri;
        $encoded_image = explode(",", $data_uri)[1];
        $decoded_image = base64_decode($encoded_image);
        
        //  Copying image to tmp file
        file_put_contents($sig, $decoded_image);

        //  Check if using mobile
        if($request->lang > 0){
            $x = 107;
            $y = 240;
        }
        else{
            $x = 105;
            $y = 258;
        }

        $mobile = new \App\Services\Mobile_Detect();
        if($mobile->isMobile()){
            $x += 6;
            $y -= 14;
        }
        
        //  Creating signature PDF file
        $pdf = new \App\Services\FPDF('P', 'mm', 'A4');
        $pdf->AddPage();
        $pdf->Image($sig,$x,$y,-300);
        file_put_contents($sigpdf, $pdf->output('S'));

        $pdf = file_get_contents('forms/BF_'. $lang .'_Fillable.pdf');

        try {
            file_put_contents($pdftmp, $pdf);

            exec(getenv("LIB_PATH") . 'pdftk '. $pdftmp .' stamp ' . $sigpdf . ' output ' . $first);

        } catch (Exception $e) {
            return $e; 
        }

        $data = $request->all();
        $data["DATE"] = date("m/d/Y");
        unset($data['_token']);

        $dfdf = toFDF($data);

        file_put_contents($fdf, $dfdf);

        exec(getenv("LIB_PATH") . "pdftk ". $first ." fill_form ". $fdf . " output tmp/final.pdf flatten");

        return;

        \Mail::raw('New application from '. $data['FIRST_NAME'] . ' ' . $data['LAST_NAME'], function($message)
        {
            $message->subject('Horsepower - Building Trades Benefit Funds Enrollment');
            $message->to('claudempserrano@gmail.com');
            $message->from('no-reply@horsepowernyc.com', 'Horsepower Electric');
            $message->attach('tmp/final.pdf');
        });

        $request->session()->put('bf', 0);

        return redirect('dashboard');
    }
    
}
