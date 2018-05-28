<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Information;
use App\Bf;
use App\Beneficiary;
use App\Dependent;
use App\Guest;
use App\Union;

class FormController extends Controller
{

	private $validate = true;

	/**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('form');
    }

    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $lang = json_decode(file_get_contents(session('lang') . '.json'));
        $form = 'registration';
        $data = null;


        if($request->session()->has('id')){
            $guest = Guest::find(session('id'));
            $data = $guest->information;
            session(['progress' => $guest->progress]);
        }

        if($request->session()->has('progress')){
            switch(session('progress')){
                case 1:
                    $form = 'bf';
                    break;
                case 2:
                    $data['bene'] = $guest->beneficiaries->take(3);
                    $form = 'union';
                    break;
                case 3:
                    $form = 'files';
                    break;
                case 4:
                    $form = 'complete';
                    break;
                default:
                    break;
            }
        }

    	return view('forms.' . $form)->with(['lang' => $lang, 'data' => $data]);
    }

    /**
     * Submit exam data.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function submit(Request $request)
    {

        switch($request->form){
            case 'reg':

                if($this->validate)
                    $request->validate([
                        'LName' => 'required',
                        'FName' => 'required',
                        'SSN1' => 'required|size:3',
                        'SSN2' => 'required|size:2',
                        'SSN3' => 'required|size:4',
                        'Street' => 'required',
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
                        'Email' => 'required',
                        'StartMonth' => 'required|size:2',
                        'StartDay' => 'required|size:2',
                        'StartYear' => 'required|size:4'
                    ]);
                // return $request->all();

                $guest = new Guest();
                $guest->name = $request->LName . ', ' . $request->FName;
                $guest->progress = 1;
                $guest->type = 'newhire';
                $guest->save();

                $data = $request->all();

                unset($data['_token']);
                $data['Signature'] = $request->uri;
                unset($data['uri']);
                $data['guest_id'] = $guest->id;

                $info = new Information();
                $info->fill($data);
                $info->save();

                session(['progress' => 1]);
                session(['id' => $guest->id]);

                return redirect('form');

                break;

            case 'bf':

                if($this->validate){
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
                     // 'JobClass' => 'required',
                     'HireDate' => 'required|date_format:m/d/Y',
                     'FAMILY_DOB1' => 'nullable|date_format:m/d/Y',
                     'FAMILY_DOB2' => 'nullable|date_format:m/d/Y',
                     'FAMILY_DOB3' => 'nullable|date_format:m/d/Y',
                     'FAMILY_DOB4' => 'nullable|date_format:m/d/Y',
                     'FAMILY_DOB5' => 'nullable|date_format:m/d/Y',
                     'FAMILY_DOB6' => 'nullable|date_format:m/d/Y',
                     'FAMILY_DOB7' => 'nullable|date_format:m/d/Y',
                     'FAMILY_DOB8' => 'nullable|date_format:m/d/Y',
                     'DateMarried' => 'nullable|date_format:m/d/Y',
                     'DateDivorced' => 'nullable|date_format:m/d/Y',
                     'SpouseDateHired' => 'nullable|date_format:m/d/Y',
                     'BENE_DOB1' => 'nullable|date_format:m/d/Y',
                     'BENE_DOB2' => 'nullable|date_format:m/d/Y',
                     'BENE_DOB3' => 'nullable|date_format:m/d/Y',
                     'BENE_DOB4' => 'nullable|date_format:m/d/Y',
                     'SpouseEmployerNumber' => 'nullable|size:14',
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
                }

                $guest_id = session('id');

                $data = $request->only(['Status', 'HireDate', 'DateMarried','PlaceMarried','DateDivorced','CourtOrder','SpouseEmployer','SpouseEmployerAddress','SpouseDateHired','SpouseEmployerNumber']);
                $data['Signature'] = $request->uri;
                $data['guest_id'] = $guest_id;

                $bf = new Bf();
                $bf->fill($data);
                $bf->save();

                for($i = 1; $i <= 8; $i++){
                    $name = 'FAMILY' . $i;

                    if($request->$name != null){

                        $dob = 'FAMILY_DOB' . $i;
                        $sex = 'SEX' . $i;
                        $ssn = 'FAMILY_SSN' . $i;
                        $relationship = 'FAMILY_RELATIONSHIP' . $i;

                        $dep = new Dependent();
                        $dep->full_name = $request->$name;
                        $dep->guest_id = $guest_id;
                        $dep->dob = $request->$dob;
                        $dep->sex = $request->$sex;
                        $dep->ssn = $request->$ssn;
                        $dep->relationship = $request->$relationship;
                        $dep->save();

                    }
                }

                for($i = 1; $i <= 3; $i++){
                    $name = 'BENEFICIARY' . $i;

                    if($request->$name != null){

                        $ssn = 'BENE_SSN' . $i;
                        $dob = 'BENE_DOB' . $i;
                        $relationship = 'BENE_RELATIONSHIP' . $i;
                        $percent = 'PCT' . $i;

                        $bene = new Beneficiary();
                        $bene->guest_id = $guest_id;
                        $bene->full_name = $request->$name;
                        $bene->ssn = $request->$ssn;
                        $bene->dob = $request->$dob;
                        $bene->relationship = $request->$relationship;
                        $bene->percent = $request->$percent;
                        $bene->save();

                    }
                }

                $guest = Guest::find(session('id'));
                $guest->progress += 1;
                $guest->save();

                session(['progress' => $guest->progress]);

                return redirect('form');

                break;

            case 'union':

                if($this->validate){
                    $request->validate([
                        'last_name' => 'required',
                        'first_name' => 'required',
                        'dob' => 'required|date_format:m/d/Y',
                        'ssn' => 'required|size:11',
                        'street_address' => 'required',
                        'city' => 'required',
                        'state' => 'required',
                        'home_zip' => 'required',
                        'HomePhone' => 'required|size:14',
                        'Email' => 'required|email',
                        'DateHired' => 'required|date_format:m/d/Y',
                    ]);
                };

                $guest_id = session('id');

                $data = $request->only(['WorkPhone', 'DateHired', 'PrimaryType', 'PrimaryName', 'PrimaryRel', 'PrimaryAddress', 'SecondaryType', 'SecondaryName', 'SecondaryRel', 'SecondaryAddress', 'TertiaryType', 'TertiaryName', 'TertiaryRel', 'TertiaryAddress']);
                $data['Signature'] = $request->uri;
                $data['guest_id'] = $guest_id;

                $union = new Union();
                $union->fill($data);
                $union->save();

                $guest = Guest::find(session('id'));
                $guest->progress += 1;
                $guest->save();

                session(['progress' => $guest->progress]);

                return redirect('form');

                break;

            case 'files':

                $guest = Guest::find(session('id'));

                try {

                    $files = $request->all();

                    unset($files['_token']);

                    $folder = 'forms/';
                    $path = $folder . $guest->id;

                    // $i = 1;

                    // while(\Storage::disk('s3')->exists($path)){
                    //     $path = $folder . $guest->id . $i;
                    //     $i++;

                    // }
                    
                    \Storage::disk('s3')->createDir($path);

                    //  Government Issued ID
                    \Storage::disk('s3')->put($path . '/GOV_ID.'.pathinfo($_FILES["id"]["name"], PATHINFO_EXTENSION), file_get_contents($_FILES["id"]["tmp_name"]));
                    unset($files['id']);

                    //  SS Card
                    \Storage::disk('s3')->put($path . '/SSN.'.pathinfo($_FILES["ssn"]["name"], PATHINFO_EXTENSION), file_get_contents($_FILES["ssn"]["tmp_name"]));
                    unset($files['ssn']);

                    //  Bank Information
                    \Storage::disk('s3')->put($path . '/DD.'.pathinfo($_FILES["dd"]["name"], PATHINFO_EXTENSION), file_get_contents($_FILES["dd"]["tmp_name"]));
                    unset($files['dd']);

                    //  OSHA
                    \Storage::disk('s3')->put($path . '/OSHA.'.pathinfo($_FILES["osha"]["name"], PATHINFO_EXTENSION), file_get_contents($_FILES["osha"]["tmp_name"]));
                        unset($files['osha']);

                    //  Scaffold Safety Certificate
                    \Storage::disk('s3')->put($path . '/SCAFFOLD.'.pathinfo($_FILES["scaffold"]["name"], PATHINFO_EXTENSION), file_get_contents($_FILES["scaffold"]["tmp_name"]));
                        unset($files['scaffold']);

                    //  Green Card
                    if(file_exists($_FILES["greencard"]["tmp_name"])){
                        \Storage::disk('s3')->put($path . '/GREEN_CARD.'.pathinfo($_FILES["greencard"]["name"], PATHINFO_EXTENSION), file_get_contents($_FILES["greencard"]["tmp_name"]));
                        unset($files['greencard']);
                    }

                    //  Marriage Certificate
                    if(file_exists($_FILES["marriage"]["tmp_name"])){
                        \Storage::disk('s3')->put($path . '/MARRIAGE_CERT.'.pathinfo($_FILES["marriage"]["name"], PATHINFO_EXTENSION), file_get_contents($_FILES["marriage"]["tmp_name"]));
                        unset($files['marriage']);
                    }

                    //  Birth Certificate/s
                    if(file_exists($_FILES["birth"]["tmp_name"][0])){
                        $size = sizeof($_FILES["birth"]["tmp_name"]);
                        for($i = 0; $i < $size; $i++){
                            \Storage::disk('s3')->put($path . '/BIRTH_CERT_'. (string) ($i + 1) .'.'.pathinfo($_FILES["birth"]["name"][$i], PATHINFO_EXTENSION), file_get_contents($_FILES["birth"]["tmp_name"][$i]));
                        }
                        unset($files['birth']);
                    }

                    //  Certifications
                    $count = 1;

                    unset($files['form']);

                    for($i = 1; $i <= sizeof($files); $i++){
                        \Storage::disk('s3')->put($path . '/CERT'. (string) ($i) .'.'.pathinfo($_FILES["cert".$i]["name"], PATHINFO_EXTENSION), file_get_contents($_FILES["cert".$i]["tmp_name"]));
                    }

                } 
                catch (Exception $e) {
                    return $e;
                }          

                $guest->progress += 1;
                $guest->save();

                session(['progress' => $guest->progress]);

                return redirect('form');

                break;
            default:

                return redirect('form');
                break;
        }
            
    }

    /**
     * Resume forms.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function resume(Request $request, $id)
    {
        session(['id' => $id]);
        return redirect('form');
    }

    /**
     * Flush sessions.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function flush(Request $request)
    {
        $request->session()->flush();
        return redirect('form');
    }

    /**
     * Change language of forms.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function changeLanguage(Request $request, $lang)
    {
        session(['lang' => $lang]);
        return redirect('form');
    }

    

}
