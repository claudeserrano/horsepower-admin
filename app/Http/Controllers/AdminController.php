<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use \App\Guest;
use mikehaertl\pdftk\Pdf;

class AdminController extends Controller
{

    private $validate = true;

	/**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	return null;
    }

    /**
     * Display results of exam.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function getExamResults()
    {
    	$guests = Guest::all()->where('type', '<>', 'newhire');
    	$arr = [];

    	foreach($guests as $guest)
    	{
    		$scores = $guest->scores;
            $avg = 0;

            if($scores != null && count($scores) > 0){
                $all = [];
                foreach($scores as $score)
                    array_push($all, $score->score);
                $avg = array_sum($all) / count($all);
            }
            array_push($arr, ['name' => $guest->name, 'id' => $guest->id, 'average' => number_format($avg,2)]);
    	}

    	return view('admin.exam.results')->with('arr', $arr);
    }

    /**
     * Display detailed results of exam.
     *
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function getEmployeeResults($id)
    {
        $guest = Guest::find($id);

        $scores = $guest->scores->where('level', '<>', 4);
        $final = $guest->scores->where('level', '=', 4)->first();
        $class = array();
        //  Temporary error checking
        if(!is_null($final))
            $answers = $final->answers;

        for($i = 0; $i <= 4; $i++){
            $temp = 0;
            //  Temporary error checking
            if(isset($answers)){
                for($a = 1; $a <= 3; $a++){
                    $temp += $answers->where('question', '=', $a + (3 * $i))->first()->correct;
                }
            }
            array_push($class, ['year' => $i + 1, 'correct' => number_format($temp / 3 * 100,2)]);
        }

        return view('admin.exam.results_emp')->with(['guest' => $guest, 'scores' => $scores, 'class' => $class]);
    }

    /**
     * Display newhires/guests who is filling out/filled out forms.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function getNewhireList()
    {
        $guests = Guest::where('type', '=', 'newhire')->get();
        $data = [];

        foreach($guests as $guest){
            switch($guest->progress){
                case 1:
                    $guest->progress = 'Building Trades Benefits Fund';
                    break;
                case 2:
                    $guest->progress = 'Union Local 363';
                    break;
                case 3:
                    $guest->progress = 'Files Upload';
                    break;
                case 4:
                    $guest->progress = 'Complete';
                    break;
                default:
                    break;
            }
            array_push($data, ['id' => $guest->id, 'name' => $guest->name, 'email' => $guest->information->Email, 'progress' => $guest->progress, 'date' => $guest->updated_at]);
        }

        return view('admin.form.list')->with('data', $data);
    }

    /**
     * Display new hire data
     *
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function getNewHireData($id)
    {
        $guest = Guest::find($id);

        return view('admin.form.data_emp')->with('guest', $guest);
    }

    /**
     * Generate employee information
     *
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function generateData($id)
    {
        // return $this->generateFormData($id);
        return $this->generateForms($id);
    }

    public function generateForms($id)
    {
        $guest = Guest::find($id);
        $structure = './tmp/' . $guest->id . '/';

        // To create the nested structure, the $recursive parameter 
        // to mkdir() must be specified.

        if(!file_exists($structure))
          if (!mkdir($structure, 0777, true)) {
              die('Failed to create folders...');
          }
          
        $reg = $this->getFormDataArray($guest, 'reg');
        $bf = $this->getFormDataArray($guest, 'bf');
        $union = $this->getFormDataArray($guest, 'union');

        $path = '/forms/';

        //  File paths
        $tmp = env('TMP_PATH', 'tmp/' . $guest->id . '/' );
        $sig = $tmp . 'sig.png';
        $sigpdf = $tmp . 'sig.pdf';
        $pdftmp = $tmp . 'form.pdf';
        $first = $tmp . 'first.pdf';
        $fdf = $tmp . 'fdf.pdf';
        $regfile = $tmp . 'registration.pdf';
        $bffile = $tmp . 'bf.pdf';
        $unionfile = $tmp . 'union.pdf';

        //  Registration

        //  Signature image processing
        $data_uri = $reg['Signature'];
        $encoded_image = explode(",", $data_uri)[1];
        $decoded_image = base64_decode($encoded_image);

        //  Copying image to tmp file
        file_put_contents($sig, $decoded_image);

        $this->image_resize($sig, $sig, 350, 200);

        $x = 175;
        $y = 270;

        //  Creating signature PDF file
        $pdf = new \App\Services\FPDF('P', 'mm', 'A4');
        $pdf->AddPage();
        $pdf->Image($sig,$x,$y,-300);
        file_put_contents($sigpdf, $pdf->output('S'));

        $pdf = file_get_contents('forms/reg.pdf');

        try {
            file_put_contents($pdftmp, $pdf);

            //  Stamp signature to PDF
            exec(getenv('LIB_PATH', '') . 'pdftk '. $pdftmp .' stamp ' . $sigpdf . ' output ' . $first);

        } catch (Exception $e) {
            return dd($e); 
        }

        unset($reg['Signature']);

        //  Create FDF file for filling up form
        $dfdf = $this->toFDF($reg);
        file_put_contents($fdf, $dfdf);

        //  Fill up form with signature & flatten file to remove editing
        //  No flatten because they have to manually add school and classification
        exec(getenv('LIB_PATH', '') . 'pdftk '. $first .' fill_form '. $fdf . ' output '. $regfile);

        //  End registration

        //  BF

        //  Signature image processing
        $data_uri = $bf['Signature'];
        $encoded_image = explode(",", $data_uri)[1];
        $decoded_image = base64_decode($encoded_image);
        
        //  Copying image to tmp file
        file_put_contents($sig, $decoded_image);

        self::image_resize($sig, $sig, 350, 200);

        $x = 127;
        $y = 240;

        //  Check if using mobile
        $mobile = new \App\Services\Mobile_Detect();
        if($mobile->isMobile()){
            $y -= 3;
        }
        
        //  Creating signature PDF file
        $pdf = new \App\Services\FPDF('P', 'mm', 'A4');
        $pdf->AddPage();
        $pdf->Image($sig,$x,$y,-300);
        file_put_contents($sigpdf, $pdf->output('S'));

        $pdf = file_get_contents('forms/bf.pdf');

        try {
            file_put_contents($pdftmp, $pdf);

            exec(getenv("LIB_PATH") . 'pdftk '. $pdftmp .' stamp ' . $sigpdf . ' output ' . $first);
        } 
        catch (Exception $e) {
            return $e; 
        }

        unset($bf['Signature']);

        $dfdf = self::toFDF($bf);

        file_put_contents($fdf, $dfdf);

        exec(getenv("LIB_PATH") . "pdftk ". $first ." fill_form ". $fdf . " output ". $bffile);

        //  End BF

        //  Union

        //  Signature image processing
        $data_uri = $union['Signature'];
        $encoded_image = explode(",", $data_uri)[1];
        $decoded_image = base64_decode($encoded_image);

        //  Copying image to tmp file
        file_put_contents($sig, $decoded_image);

        self::image_resize($sig, $sig, 350, 200);

        //  Check if using mobile
        $x1 = 9.25;
        $x2 = 3.5;
        $y1 = 3.30;
        $y2 = 5.15;
        $y3 = 7.55;
        
        //  Creating signature PDF file
        $pdf = new \App\Services\FPDF('L', 'in', [11, 8.52]);
        $pdf->AddPage();
        $pdf->Image($sig,$x1,$y1,-300);
        $pdf->Image($sig,$x1,$y2,-300);
        $pdf->Image($sig,$x2,$y3,-300);
        file_put_contents($sigpdf, $pdf->output('S'));

        $pdf = file_get_contents('forms/union.pdf');

        try {
            file_put_contents($pdftmp, $pdf);

            exec(getenv("LIB_PATH") . 'pdftk '. $pdftmp .' stamp ' . $sigpdf . ' output ' . $first);
        } 
        catch (Exception $e) {
            return $e; 
        }
        unset($union['Signature']);

        $dfdf = self::toFDF($union);

        file_put_contents($fdf, $dfdf);

        exec(getenv("LIB_PATH") . "pdftk ". $first ." fill_form ". $fdf . " output ". $unionfile);

        //  End Union

        if(file_exists('file.zip'))
          unlink('file.zip');

        $forms = array(
            ['path' => $regfile, 'name' => 'reg.pdf'], ['path' => $bffile, 'name' => 'bf.pdf'], ['path' => $unionfile, 'name' => 'union.pdf']
        );

        $uploads =  $this->getUploadedFiles($id, $tmp);

        if($uploads){
            foreach($uploads as $upload){
                array_push($forms, $upload);
            }
        }

        $zipname = 'file.zip';
        $zip = new \ZipArchive;
        $zip->open($zipname, \ZipArchive::CREATE);
        foreach ($forms as $form) {
            $zip->addFile($form['path'], $guest->name . '/' . $form['name']);
        }

        $zip->close();

        $this->cleanTmp($tmp);

        return response()->download($zipname);

    }

    public function cleanTmp($tmp){
        $files = array_diff(scandir($tmp), array('.', '..'));
        foreach($files as $file){
            unlink($tmp . $file);
        }
        rmdir($tmp);
    }

    public function getUploadedFiles($id, $tmp)
    {

        $path = 'forms/' . $id;
        //  Check if path exists
        if(Storage::disk('s3')->exists($path)){
            $files = Storage::disk('s3')->allFiles($path);
            $uploads = array();

            foreach($files as $file){
                $name = Storage::disk('s3')->getMetaData($file)['basename'];
                file_put_contents($tmp . $name, Storage::disk('s3')->get($file));
                array_push($uploads, ['path' => $tmp . $name, 'name' => $name]);
            }

            return $uploads;
        }
        
        return null;

    }

    public function getFormDataArray($guest, $form)
    {
        $info = $guest->information;
        switch($form)
        {
          case 'reg':
              $arr = [
                'Name' => $info->FName . ' ' . $info->MI . ' ' . $info->LName ,
                'SSN1' => $info->SSN1,
                'SSN2' => $info->SSN2,
                'SSN3' => $info->SSN3,
                'Address1' => $info->Number . ' ' . $info->Street . ' ' . $info->aptNo,
                'City' => $info->City,
                'State' => $info->State,
                'Zip' => $info->Zip,
                'AreaCode' => $info->AreaCode,
                'TelNo1' => $info->TelNo1,
                'TelNo2' => $info->TelNo2,
                'AreaCodePhone' => $info->AreaCodePhone,
                'CellNo1' => $info->CellNo1,
                'CellNo2' => $info->CellNo2,
                'DOBMonth' => $info->DOBMonth,
                'DOBDay' => $info->DOBDay,
                'DOBYear' => $info->DOBYear,
                'StartYear' => $info->StartYear,
                'StartMonth' => $info->StartMonth,
                'StartDay' => $info->StartDay,
                'Email' => $info->Email,
                'EthnicGroup' => $info->EthnicGroup,
                'Race' => $info->Race,
                'Sex' => $info->Sex,
                'Veteran' => $info->Veteran,
                'Signature' => $info->Signature
              ];

              return $arr;
              break;
          case 'bf':
              $bf = $guest->bf;
              $dependents = ($guest->dependents != null) ? $guest->dependents : [];
              $benefs = ($guest->beneficiaries != null) ? $guest->beneficiaries : [];

              $arr = [
                'LName' => $info->LName,
                'FName' => $info->FName,
                'MI' => $info->MI,
                'SSN' => $info->SSN1 . '-' . $info->SSN2 . '-' . $info->SSN3,
                'Sex' => $info->Sex,
                'Street' => isset($info->Number) ? $info->Number . ' ' . $info->Street : $info->Street,
                'Number' => $info->aptNo,
                'DOB' => $info->DOBMonth . '/' . $info->DOBDay . '/' . $info->DOBYear,
                'HomeNumber' => '(' . $info->AreaCode . ') ' . $info->TelNo1 . '-' . $info->TelNo2,
                'City' => $info->City,
                'State' => $info->State,
                'Zip' => $info->Zip,
                'Email' => $info->Email,
                'DateMarried' => $info->DateMarried,
                'PlaceMarried' => $info->PlaceMarried,
                'DateDivorced' => $info->DateDivorced,
                'CourtOrder' => $info->CourtOrder,
                'SpouseEmployer' => $info->SpouseEmployer,
                'SpouseEmployerAddress' => $info->SpouseEmployerAddress,
                'SpouseDateHired' => $info->SpouseDateHired,
                'SpouseEmployerNumber' => $info->SpouseEmployerNumber,
                'Status' => $bf->Status,
                'HireDate' => $bf->HireDate,
                'DateMarried' => $bf->DateMarried,
                'PlaceMarried' => $bf->PlaceMarried,
                'DateDivorced' => $bf->DateDivorced,
                'CourtOrder' => $bf->CourtOrder,
                'SpouseEmployer' => $bf->SpouseEmployer,
                'SpouseEmployerAddress' => $bf->SpouseEmployerAddress,
                'SpouseDateHired' => $bf->SpouseDateHired,
                'SpouseEmployerNumber' => $bf->SpouseEmployerNumber,
                'Signature' => $info->Signature,
                'ShopName' => 'Horsepower Electric',
              ];

              for($i = 1; $i <= sizeof($dependents); $i++){
                $arr['FAMILY' . $i] = $dependents[$i - 1]->full_name;
                $arr['FAMILY_DOB' . $i] = $dependents[$i - 1]->dob;
                $arr['FAMILY_SSN' . $i] = $dependents[$i - 1]->ssn;
                $arr['FAMILY_RELATIONSHIP' . $i] = $dependents[$i - 1]->relationship;
              }

              for($i = 1; $i <= sizeof($benefs); $i++){
                $arr['BENEFICIARY' . $i] = $benefs[$i - 1]->full_name;
                $arr['BENE_SSN' . $i] = $benefs[$i - 1]->dob;
                $arr['BENE_DOB' . $i] = $benefs[$i - 1]->ssn;
                $arr['BENE_RELATIONSHIP' . $i] = $benefs[$i - 1]->relationship;
                $arr['PCT' . $i] = $benefs[$i - 1]->percent;
              }

              $arr['DATE'] = date('m/d/Y');

              return $arr;
              break;
          case 'union':
              $union = $guest->union;
              $bf = $guest->bf;
              $status = $bf->Status;
              $benefs = ($guest->beneficiaries != null) ? $guest->beneficiaries->take(3) : [];
              $arr = [
                'LName' => $info->LName,
                'FName' => $info->FName,
                'MI' => $info->MI,
                'SSN' => $info->SSN1 . '-' . $info->SSN2 . '-' . $info->SSN3,
                'Sex' => $info->Sex,
                'Street' => isset($info->Number) ? $info->Number . ' ' . $info->Street : $info->Street,
                'Number' => $info->aptNo,
                'DOB' => $info->DOBMonth . '/' . $info->DOBDay . '/' . $info->DOBYear,
                'HomeNumber' => '(' . $info->AreaCode . ') ' . $info->TelNo1 . '-' . $info->TelNo2,
                'Status' => $status,
                'City' => $info->City,
                'State' => $info->State,
                'Zip' => $info->Zip,
                'Email' => $info->Email,
                'WorkPhone' => $union->WorkPhone,
                'DateHired' => $union->DateHired,
                'PrimaryName' => $union->PrimaryName,
                'PrimaryRel' => $union->PrimaryRel,
                'PrimaryAddress' => $union->PrimaryAddress,
                'SecondaryName' => $union->SecondaryName,
                'SecondaryRel' => $union->SecondaryRel,
                'SecondaryAddress' => $union->SecondaryAddress,
                'TertiaryName' => $union->TertiaryName,
                'TertiaryRel' => $union->TertiaryRel,
                'TertiaryAddress' => $union->TertiaryAddress,
                'Signature' => $union->Signature,
                'date1' => date('m/d/Y'),
                'date2' => date('m/d/Y'),
                'date3' => date('m/d/Y'),
                'CompanyName' => 'Horsepower Electric and Maintenance',
                'CompanyAddress' => '4101 1st Avenue Brooklyn, NY',
                'WorkZip' => '11232',
              ];
              return $arr;
              break;
          default:
              break;
        }
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

    function image_resize($src, $dst, $width, $height, $crop=0){

      if(!list($w, $h) = getimagesize($src)) return "Unsupported picture type!";

      $type = strtolower(substr(strrchr($src,"."),1));
      if($type == 'jpeg') $type = 'jpg';
      switch($type){
        case 'bmp': $img = \imagecreatefromwbmp($src); break;
        case 'gif': $img = \imagecreatefromgif($src); break;
        case 'jpg': $img = \imagecreatefromjpeg($src); break;
        case 'png': $img = \imagecreatefrompng($src); break;
        default : return "Unsupported picture type!";
      }

      // resize
      if($crop){
        if($w < $width or $h < $height) return "Picture is too small!";
        $ratio = max($width/$w, $height/$h);
        $h = $height / $ratio;
        $x = ($w - $width / $ratio) / 2;
        $w = $width / $ratio;
      }
      else{
        if($w < $width and $h < $height) return "Picture is too small!";
        $ratio = min($width/$w, $height/$h);
        $width = $w * $ratio;
        $height = $h * $ratio;
        $x = 0;
      }

      $new = \imagecreatetruecolor($width, $height);

      // preserve transparency
      if($type == "gif" or $type == "png"){
        \imagecolortransparent($new, \imagecolorallocatealpha($new, 0, 0, 0, 127));
        \imagealphablending($new, false);
        \imagesavealpha($new, true);
      }

      \imagecopyresampled($new, $img, 0, 0, $x, 0, $width, $height, $w, $h);

      switch($type){
        case 'bmp': \imagewbmp($new, $dst); break;
        case 'gif': \imagegif($new, $dst); break;
        case 'jpg': \imagejpeg($new, $dst); break;
        case 'png': \imagepng($new, $dst); break;
      }

      return true;

    }

}
