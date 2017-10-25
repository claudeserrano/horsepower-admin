<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Key;

class DashboardController extends Controller
{
	/**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('horsepower');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $progress = session()->get('progress');
        $value = 0;
        $next = '';
        $route = '';
        $lang = 'english';

        switch($progress)
        {
            case 0:
                $next = 'Request for Employee Registration';
                $route = 'reg_emp';
                break;
            case 1:
                $next = 'Building Trades Benefit Funds Enrollment';
                $route = 'build_trade';
                $value = 33;
                break;

            case 2:
                $next = 'Upload Required Files';
                $route = 'files';
                $value = 66;
                break;
            case 3:
                $value = 100;
            default: 
                break;
        }
    
        return view('dashboard', ['next' => $next, 'route' => $route, 'value' => $value, 'lang' => $lang]);

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

        // //  File paths
        // $tmp = env('TMP_PATH', 'tmp/');
        // $sig = $tmp . 'sig.png';
        // $sigpdf = $tmp . 'sig.pdf';
        // $pdftmp = $tmp . 'form.pdf';
        // $first = $tmp . 'first.pdf';
        // $fdf = $tmp . 'fdf.pdf';

        // //  Signature image processing
        // $data_uri = $request->uri;
        // $encoded_image = explode(",", $data_uri)[1];
        // $decoded_image = base64_decode($encoded_image);

        // //  Copying image to tmp file
        // file_put_contents($sig, $decoded_image);

        // $y = 265;

        // //  Check if using mobile
        // $mobile = new \App\Services\Mobile_Detect();
        // if($mobile->isMobile()){
        //     $y -= 10;
        // }

        // //  Creating signature PDF file
        // $pdf = new \App\Services\FPDF('P', 'mm', 'A4');
        // $pdf->AddPage();
        // $pdf->Image($sig,165,$y,-300);
        // file_put_contents($sigpdf, $pdf->output('S'));

        // $pdf = file_get_contents('forms/Registration_'.$lang.'_Fillable.pdf');

        // try {
        //     file_put_contents($pdftmp, $pdf);

        //     //  Stamp signature to PDF
        //     exec(getenv('LIB_PATH', '') . 'pdftk '. $pdftmp .' stamp ' . $sigpdf . ' output ' . $first);

        // } catch (Exception $e) {
        //     return $e; 
        // }

        // $data = $request->all();
        // unset($data['_token']);

        // //  Create FDF file for filling up form
        // $dfdf = self::toFDF($data);
        // file_put_contents($fdf, $dfdf);

        // //  Fill up form with signature & flatten file to remove editing
        // exec(getenv('LIB_PATH', '') . 'pdftk '. $first .' fill_form '. $fdf . ' output tmp/final.pdf flatten');

        // \Mail::raw('New application from ' . $data['Name'], function($message)
        // {
        //     $message->subject('Horsepower - Request for Employee Registration');
        //     $message->to('claude@horsepowernyc.com');
        //     $message->from('no-reply@horsepowernyc.com', 'Horsepower Electric');
        //     $message->attach('tmp/final.pdf');
        // });

        if(self::updateKeyModel(session('index'), session()->get('progress') + 1, 'progress'))
            session()->put('progress', session()->get('progress') + 1);

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

        // //  File paths
        // $tmp = env('TMP_PATH', 'tmp/');
        // $sig = $tmp . 'sig.png';
        // $sigpdf = $tmp . 'sig.pdf';
        // $pdftmp = $tmp . 'form.pdf';
        // $first = $tmp . 'first.pdf';
        // $fdf = $tmp . 'fdf.pdf';

        // //  Signature image processing
        // $data_uri = $request->uri;
        // $encoded_image = explode(",", $data_uri)[1];
        // $decoded_image = base64_decode($encoded_image);
        
        // //  Copying image to tmp file
        // file_put_contents($sig, $decoded_image);

        // //  Check if using mobile
        // if($request->lang > 0){
        //     $x = 107;
        //     $y = 240;
        // }
        // else{
        //     $x = 105;
        //     $y = 258;
        // }

        // $mobile = new \App\Services\Mobile_Detect();
        // if($mobile->isMobile()){
        //     $x += 6;
        //     $y -= 14;
        // }
        
        // //  Creating signature PDF file
        // $pdf = new \App\Services\FPDF('P', 'mm', 'A4');
        // $pdf->AddPage();
        // $pdf->Image($sig,$x,$y,-300);
        // file_put_contents($sigpdf, $pdf->output('S'));

        // $pdf = file_get_contents('forms/BF_'. $lang .'_Fillable.pdf');

        // try {
        //     file_put_contents($pdftmp, $pdf);

        //     exec(getenv("LIB_PATH") . 'pdftk '. $pdftmp .' stamp ' . $sigpdf . ' output ' . $first);

        // } catch (Exception $e) {
        //     return $e; 
        // }

        // $data = $request->all();
        // $data["DATE"] = date("m/d/Y");
        // unset($data['_token']);

        // $dfdf = self::toFDF($data);

        // file_put_contents($fdf, $dfdf);

        // exec(getenv("LIB_PATH") . "pdftk ". $first ." fill_form ". $fdf . " output tmp/final.pdf flatten");

        // \Mail::raw('New application from '. $data['FIRST_NAME'] . ' ' . $data['LAST_NAME'], function($message)
        // {
        //     $message->subject('Horsepower - Building Trades Benefit Funds Enrollment');
        //     $message->to('claudempserrano@gmail.com');
        //     $message->from('no-reply@horsepowernyc.com', 'Horsepower Electric');
        //     $message->attach('tmp/final.pdf');
        // });

        if(self::updateKeyModel(session('index'), session()->get('progress') + 1, 'progress'))
            session()->put('progress', session()->get('progress') + 1);

        return redirect('dashboard');
    }

    public function uploadFiles(Request $request)
    {
    
        $folder_name = session('empid');

        $folder = self::checkDrive($folder_name);

        if($folder == false){
            if(\Storage::disk('google')->createDir($folder_name))
                $folder = self::checkDrive($folder_name);
        }

        $path = $folder['path'] . "/";

        //  Government Issued ID
        \Storage::disk('google')->put($path . 'GOVID.'.pathinfo($_FILES["id"]["name"], PATHINFO_EXTENSION), file_get_contents($_FILES["id"]["tmp_name"]));

        //  SS Card
        \Storage::disk('google')->put($path . 'SSN.'.pathinfo($_FILES["ssn"]["name"], PATHINFO_EXTENSION), file_get_contents($_FILES["ssn"]["tmp_name"]));

        //  Bank Information
        \Storage::disk('google')->put($path . 'DD.'.pathinfo($_FILES["dd"]["name"], PATHINFO_EXTENSION), file_get_contents($_FILES["dd"]["tmp_name"]));


        //  Green Card
        // \Storage::disk('google')->put($path . 'GREENCARD.'.pathinfo($_FILES["greencard"]["name"], PATHINFO_EXTENSION), file_get_contents($_FILES["greencard"]["tmp_name"]));

        //  if (move_uploaded_file($_FILES["id"]["tmp_name"], $dir . '/ID.' . pathinfo($_FILES["id"]["name"], PATHINFO_EXTENSION)))
        //         echo "Your files have been uploaded.";
        //     else
        //         echo "Sorry, there was an error uploading your file.";

     //    //   Green Card

        //     if (move_uploaded_file($_FILES["greencard"]["tmp_name"], $dir . '/GCARD.' . pathinfo($_FILES["greencard"]["name"], PATHINFO_EXTENSION)))
        //         echo "Your files have been uploaded.";
        //     else
        //         echo "Sorry, there was an error uploading your file.";

     //    //   SSN

        //     if (move_uploaded_file($_FILES["ssn"]["tmp_name"], $dir . '/SSN.' . pathinfo($_FILES["ssn"]["name"], PATHINFO_EXTENSION)))
        //         echo "Your files have been uploaded.";
        //     else
        //         echo "Sorry, there was an error uploading your file.";

     //    //   Direct Deposit

        //     if (move_uploaded_file($_FILES["dd"]["tmp_name"], $dir . '/DD.' . pathinfo($_FILES["dd"]["name"], PATHINFO_EXTENSION)))
        //         echo "Your files have been uploaded.";
        //     else
        //         echo "Sorry, there was an error uploading your file.";

        //  Certifications


        return redirect()->route('dashboard');
    }


    function checkDrive($filename){
        foreach(\Storage::disk('google')->listContents() as $item){
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

    function updateKeyModel($index, $data, $column)
    {

        try {
            $key = Key::find($index);
            $key->$column = $data;
            $key->save();
            
            return true;
        } 
        catch (Exception $e) {
            return false;
        }

    }
    
}
