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
    public function sendReg(Request $request, $lang) {

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

        //  Signature image processing
        $data_uri = $request->uri;
        $encoded_image = explode(",", $data_uri)[1];
        $decoded_image = base64_decode($encoded_image);

        //  Copying image to tmp file
        $sig = @tempnam("/tmp", 'sig');
        rename($sig, $sig .= '.png');

        $handle = fopen($sig, "w");
        fwrite($handle, $decoded_image);
        fclose($handle);

        $y = 265;

        $mobile = new \App\Services\Mobile_Detect();

        if($mobile->isMobile()){
            $y -= 10;
        }

        $pdf = new \App\Services\FPDF('P', 'mm', 'A4');
        $pdf->AddPage();
        $pdf->Image($sig,165,$y,-300);

        $sig = @tempnam("/tmp", 'sig');
        rename($sig, $sig .= '.png');

        $handle = fopen($sig, "w");
        fwrite($handle, $pdf->output('S'));
        fclose($handle);

        $pdf = file_get_contents('forms/Registration_'.$lang.'_Fillable.pdf');
        $fin = '';

        try {
            $pdftmp = @tempnam("/tmp", 'pdftmp');
            rename($pdftmp, $pdftmp .= '.pdf');

            $handle = fopen($pdftmp, "w");
            fwrite($handle, $pdf);
            fclose($handle);

            exec(getenv('LIB_PATH', '') . 'pdftk '. $pdftmp .' stamp ' . $sig . ' output /tmp/first.pdf');

        } catch (Exception $e) {
            return $e; 
        }

        $data = $request->all();
        unset($data['_token']);

        $dfdf = toFDF($data);

        $fdf = @tempnam("/tmp", 'fdf');
        rename($fdf, $fdf .= '.pdf');

        $handle = fopen($fdf, "w");
        fwrite($handle, $dfdf);
        fclose($handle);

        exec(getenv('LIB_PATH', '') . "pdftk /tmp/first.pdf fill_form ". $fdf . " output /tmp/final.pdf");

        \Mail::raw('New application from ' . $data['Name'], function($message) use($final)
        {
            $message->subject('Horsepower - Request for Employee Registration');
            $message->to('claudempserrano@gmail.com');
            $message->from('no-reply@horsepowernyc.com', 'Horsepower Electric');
            $message->attach('/tmp/final.pdf');
        });

        $request->session()->put('reg', 0);

        return redirect('dashboard');

    }
    
}
