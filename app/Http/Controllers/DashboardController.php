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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $progress = session()->get('progress');
        $value = 0;
        $next = null;
        $route = null;
        $lang = 'english';
        $index = 0;

        switch($progress)
        {
            case 0:
                $next = 'Request for Employee Registration';
                $route = 'reg_emp';
                break;
            case 1:
                $next = 'Building Trades Benefit Funds Enrollment';
                $route = 'build_trade';
                $value = 25;
                $index = 1;
                break;
            case 2:
                $next = 'Local 363 Enrollment Form';
                $route = 'union';
                $value = 50;
                $index = 2;
                break;
            case 3:
                $next = 'Upload Required Files';
                $route = 'files';
                $value = 75;
                $index = 3;
                break;
            default: 
                $value = 100;
                $index = 4;
                break;
        }
    
        return view('dashboard', ['next' => $next, 'route' => $route, 'value' => $value, 'lang' => $lang, 'index' => $index]);
    }

    /**
     * Get registration form view.
     * 
     * @param  \Illuminate\Http\Request $request
     * @param string $lang Language of the form.
     * @return \Illuminate\Http\Response
     */
    public function registration(Request $request, $lang)
    {
        if(session('progress') == 0)
            return view($lang . '/registration');
        else
            return redirect('dashboard');
    }


    /**
     * Get build trade form view.
     * 
     * @param  \Illuminate\Http\Request $request
     * @param string $lang Language of the form.
     * @return \Illuminate\Http\Response
     */
    public function bf(Request $request, $lang)
    {
        if(session('progress') == 1)
            return view($lang . '/bf');
        else
            return redirect('dashboard');
    }

    /**
     * Get union form view.
     * 
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function union(Request $request)
    {
        if(session('progress') == 2){
            return view('union');
        }
        else
            return redirect('dashboard');
    }

    /**
     * Get files upload view.
     * 
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function files(Request $request)
    {
        if(session('progress') == 3){

        \Mail::raw('New application from '. session('full_name') . '. Please check https://webapp.horsepowernyc.com/drive for the employee information.', function($message)
        {
            $message->subject('New Application - Horsepower Web Application');
            $message->to('jpecikonis@horsepowernyc.com');
            $message->from('no-reply@horsepowernyc.com', 'Horsepower Electric');
        });

            return view('files');
        }
        else
            return redirect('dashboard');
    }

    /**
     * Submit registration form.
     * 
     * @param  \Illuminate\Http\Request 
     * @param  string $lang
     * @return \Illuminate\Http\Response
     */
    public function sendReg(Request $request, $lang) 
    {

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
            // 'Classification' => 'required',
            // 'SchoolClass' => 'required',
        ]);

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
        $dfdf = self::toFDF($data);
        file_put_contents($fdf, $dfdf);

        //  Fill up form with signature & flatten file to remove editing
        //  No flatten because they have to manually add school and classification
        exec(getenv('LIB_PATH', '') . 'pdftk '. $first .' fill_form '. $fdf . ' output '. $tmp .'final.pdf');

        // \Mail::raw('New application from ' . $data['Name'], function($message) use($tmp)
        // {
        //     $message->subject('Horsepower - Request for Employee Registration');
        //     $message->to('jpecikonis@horsepowernyc.com');
        //     $message->from('no-reply@horsepowernyc.com', 'Horsepower Electric');
        //     $message->attach($tmp . 'final.pdf', ['as' => 'registration.pdf', 'mime' => 'application/pdf']);
        // });

        $folder_name = session('full_name');

        $folder = self::checkDrive($folder_name);

        if($folder == false){
            if(\Storage::disk('google')->createDir($folder_name)){
                $folder = self::checkDrive($folder_name);
            }
        }

        $path = $folder['path'] . "/";

        \Storage::disk('google')->put($path . 'REG.pdf', file_get_contents($tmp . 'final.pdf'));

        if(self::updateKeyModel(session('index'), session()->get('progress') + 1, 'progress'))
            session()->put('progress', session()->get('progress') + 1);

        return redirect('dashboard');

    }

    /**
     * Submit build trade.
     * 
     * @param  \Illuminate\Http\Request 
     * @param  string $lang
     * @return \Illuminate\Http\Response
     */
    public function sendBF(Request $request, $lang)
    {
        
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
         'SPOUSE_DATE_HIRED' => 'nullable|date_format:m/d/Y',
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
        } 
        catch (Exception $e) {
            return $e; 
        }

        $data = $request->all();
        $data["DATE"] = date("m/d/Y");
        unset($data['_token']);

        $dfdf = self::toFDF($data);

        file_put_contents($fdf, $dfdf);

        exec(getenv("LIB_PATH") . "pdftk ". $first ." fill_form ". $fdf . " output ". $tmp ."final.pdf flatten");

        // \Mail::raw('New application from '. $data['FIRST_NAME'] . ' ' . $data['LAST_NAME'], function($message) use($tmp)
        // {
        //     $message->subject('Horsepower - Building Trades Benefit Funds Enrollment');
        //     $message->to('jpecikonis@horsepowernyc.com');
        //     $message->from('no-reply@horsepowernyc.com', 'Horsepower Electric');
        //     $message->attach($tmp . 'final.pdf', ['as' => 'registration.pdf', 'mime' => 'application/pdf']);
        // });

        $folder_name = session('full_name');

        $folder = self::checkDrive($folder_name);

        if($folder == false){
            if(\Storage::disk('google')->createDir($folder_name)){
                $folder = self::checkDrive($folder_name);
            }
        }

        $path = $folder['path'] . "/";

        \Storage::disk('google')->put($path . 'BUILD_TRADE.pdf', file_get_contents($tmp . 'final.pdf'));

        if(self::updateKeyModel(session('index'), session()->get('progress') + 1, 'progress'))
            session()->put('progress', session()->get('progress') + 1);

        return redirect('dashboard');
    }

    /**
     * Upload the files to the drive.
     * @param  Request $request
     * @return Illuminate\Http\Response
     */
    public function uploadFiles(Request $request)
    {
        $files = $request->all();
        unset($files['_token']);

        $folder_name = session('full_name');

        $folder = self::checkDrive($folder_name);

        if($folder == false){
            if(\Storage::disk('google')->createDir($folder_name)){
                $folder = self::checkDrive($folder_name);
            }
        }

        $path = $folder['path'] . "/";

        //  Government Issued ID
        \Storage::disk('google')->put($path . 'GOV_ID.'.pathinfo($_FILES["id"]["name"], PATHINFO_EXTENSION), file_get_contents($_FILES["id"]["tmp_name"]));
        unset($files['id']);

        //  SS Card
        \Storage::disk('google')->put($path . 'SSN.'.pathinfo($_FILES["ssn"]["name"], PATHINFO_EXTENSION), file_get_contents($_FILES["ssn"]["tmp_name"]));
        unset($files['ssn']);

        //  Bank Information
        \Storage::disk('google')->put($path . 'DD.'.pathinfo($_FILES["dd"]["name"], PATHINFO_EXTENSION), file_get_contents($_FILES["dd"]["tmp_name"]));
        unset($files['dd']);

        //  Green Card
        if(file_exists($_FILES["greencard"]["tmp_name"])){
            \Storage::disk('google')->put($path . 'GREEN_CARD.'.pathinfo($_FILES["greencard"]["name"], PATHINFO_EXTENSION), file_get_contents($_FILES["greencard"]["tmp_name"]));
            unset($files['greencard']);
        }

        //  OSHA
        if(file_exists($_FILES["osha"]["tmp_name"])){
            \Storage::disk('google')->put($path . 'OSHA.'.pathinfo($_FILES["osha"]["name"], PATHINFO_EXTENSION), file_get_contents($_FILES["osha"]["tmp_name"]));
            unset($files['osha']);
        }

        //  Scaffold Safety Certificate
        if(file_exists($_FILES["scaffold"]["tmp_name"])){
            \Storage::disk('google')->put($path . 'SCAFFOLD.'.pathinfo($_FILES["scaffold"]["name"], PATHINFO_EXTENSION), file_get_contents($_FILES["scaffold"]["tmp_name"]));
            unset($files['scaffold']);
        }

        //  Marriage Certificate
        if(file_exists($_FILES["marriage"]["tmp_name"])){
            \Storage::disk('google')->put($path . 'MARRIAGE_CERT.'.pathinfo($_FILES["marriage"]["name"], PATHINFO_EXTENSION), file_get_contents($_FILES["marriage"]["tmp_name"]));
            unset($files['marriage']);
        }

        //  Birth Certificate/s
        if(file_exists($_FILES["birth"]["tmp_name"][0])){
            $size = sizeof($_FILES["birth"]["tmp_name"]);
            for($i = 0; $i < $size; $i++){
                \Storage::disk('google')->put($path . 'BIRTH_CERT_'. (string) ($i + 1) .'.'.pathinfo($_FILES["birth"]["name"][$i], PATHINFO_EXTENSION), file_get_contents($_FILES["birth"]["tmp_name"][$i]));
            }
            unset($files['birth']);
        }

        //  Certifications
        $count = 1;

        foreach($files as $file){
            \Storage::disk('google')->put($path .'CERT'. $count .'.'. $file->guessExtension(), file_get_contents($file->getRealPath()));
            $count++;
        }

        if(self::updateKeyModel(session('index'), session()->get('progress') + 1, 'progress'))
            session()->put('progress', session()->get('progress') + 1);

        return redirect('dashboard');
    }

    /**
     * Send the information to union.
     * @param  Request $request
     * @return Illuminate\Http\Response
     */
    public function sendUnion(Request $request)
    {
        $request->validate([
            'last_name' => 'required',
            'first_name' => 'required',
            'dob' => 'required|date',
            'ssn' => 'required|size:11',
            'street_address' => 'required',
            'city' => 'required',
            'state' => 'required',
            'home_zip' => 'required',
            'home_phone' => 'required|size:14',
            'email' => 'required|email',
            'date_of_hire' => 'required|date',
            'primary_name' => 'required',
            'primary_relationship' => 'required',
            'primary_address' => 'required'
        ]);

        if((!is_null($request->secondary_name)) || (!is_null($request->secondary_relationship)) || (!is_null($request->secondary_address))){
            $request->validate([
                'secondary_name' => 'required',
                'secondary_relationship' => 'required',
                'secondary_address' => 'required'
            ]);
        }

        if((!is_null($request->tertiary_name)) || (!is_null($request->tertiary_relationship)) || (!is_null($request->tertiary_address))){
            $request->validate([
                'tertiary_name' => 'required',
                'tertiary_relationship' => 'required',
                'tertiary_address' => 'required'
            ]);
        }

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
        $x1 = 8.75;
        $x2 = 3;
        $y1 = 3.15;
        $y2 = 5;
        $y3 = 7.40;

        $mobile = new \App\Services\Mobile_Detect();
        if($mobile->isMobile()){
            $y1 -= .25;
            $y2 -= .25;
            $y3 -= .25;
        }
        
        //  Creating signature PDF file
        $pdf = new \App\Services\FPDF('L', 'in', [11, 8.52]);
        $pdf->AddPage();
        $pdf->Image($sig,$x1,$y1,-300);
        $pdf->Image($sig,$x1,$y2,-300);
        $pdf->Image($sig,$x2,$y3,-300);
        file_put_contents($sigpdf, $pdf->output('S'));

        $pdf = file_get_contents('forms/Local363.pdf');

        try {
            file_put_contents($pdftmp, $pdf);

            exec(getenv("LIB_PATH") . 'pdftk '. $pdftmp .' stamp ' . $sigpdf . ' output ' . $first);
        } 
        catch (Exception $e) {
            return $e; 
        }

        $data = $request->all();
        $data["date1"] = date("m/d/Y");
        $data["date2"] = date("m/d/Y");
        $data["date3"] = date("m/d/Y");
        unset($data['_token']);

        $dfdf = self::toFDF($data);

        file_put_contents($fdf, $dfdf);

        exec(getenv("LIB_PATH") . "pdftk ". $first ." fill_form ". $fdf . " output ". $tmp ."final.pdf flatten");

        $folder_name = session('full_name');

        $folder = self::checkDrive($folder_name);

        if($folder == false){
            if(\Storage::disk('google')->createDir($folder_name)){
                $folder = self::checkDrive($folder_name);
            }
        }

        $path = $folder['path'] . "/";

        \Storage::disk('google')->put($path . 'LOCAL363.pdf', file_get_contents($tmp . 'final.pdf'));

        if(self::updateKeyModel(session('index'), session()->get('progress') + 1, 'progress'))
            session()->put('progress', session()->get('progress') + 1);

        \Mail::raw('New application from '. session('full_name') . '. Please check https://webapp.horsepowernyc.com/drive for the employee information.', function($message)
        {
            $message->subject('New Application - Horsepower Web Application');
            $message->to('jpecikonis@horsepowernyc.com');
            $message->from('no-reply@horsepowernyc.com', 'Horsepower Electric');
        });

        return redirect('dashboard');
    }

    /**
     * Check google drive if filename exists.
     * 
     * @param  string $filename Filename to check.
     * @return boolean/string
     */
    function checkDrive($filename){
        foreach(\Storage::disk('google')->listContents() as $item){
            if(!strcmp($item['filename'], $filename))
                return $item;
        }
        return false;
    }

    /**
     * Create a FDF file from array.
     *    
     * @param  array $arr Array of values to generate FDF.
     * @return FDF raw data
     */
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

    /**
     * Update a column for Key model.
     * 
     * @param  int $index  ID of the Key instance.
     * @param  mixed $data   Data to be put into model.
     * @param  string $column Column name.
     * @return boolean
     */
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
