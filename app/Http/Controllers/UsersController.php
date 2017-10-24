<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Facades\App\Services\UltiPro;

class UsersController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // ->middleware('');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @param  $token Login token of employee.
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $id = null, $token = null)
    {
        // return \App\Services\UltiPro::login();
        // return \App\Services\UltiPro::getBI();
        // return \App\Services\UltiPro::getEmpById('30066va');
        // return \App\Services\UltiPro::findEmployees();

        if(is_null($token) || is_null($id))
            return view('auth.error');
        else{
            return view('auth.validate', ['id' => $id, 'token' => $token]);
        }
    }

    /**
     * Get generate view.
     * 
     * @return \Illuminate\Http\Response
     */
    public function getGenerateView()
    {
        return view('admin.generate');
    }

    /**
     * Generate key for new hire.
     *
     * @param Illuminate\Http\Request $request
     * @return void
     */
    public function generateKey(Request $request)
    {

        $id = $request->id;
        $emp = UltiPro::validateId($id);
        $error = '';

        if($emp){
            $empl = \App\Key::where('empid', $request->id)->first();

            if(!is_null($empl))
                $error = "There is a token assigned to this employee.";
            else{
                $rand = str_random(32);
                $token = openssl_encrypt($rand, 'AES-128-ECB', base64_encode($id));
                $token = hash('sha256', $token);

                $key = new \App\Key;
                $key->value = $rand;
                $key->token = $token;
                $key->empid = $emp['EmployeeIdentifier']['EmployeeNumber'];
                $key->save();

                $msg = 'Your Horsepower employee number is '. $emp['EmployeeIdentifier']['EmployeeNumber'] .'. Please click on this link localhost/horsepower/public/token/'.$key->id.'/'.$token.' to finish your enrollment.';

                \Mail::raw($msg, function($message) use($emp)
                {
                    $message->subject('Horsepower - Onboarding Todo List');
                    $message->to($emp['EmailAddress']);
                    $message->from('no-reply@horsepowernyc.com', 'Horsepower Electric');
                });

                return view('admin.success');
            }
        }
        else
            $error = 'Invalid employee.';

        return back()->withInput()->withErrors(['empNum' => $error]);
    }


    /**
     * Validates the key input.
     * 
     * @param  Illuminate\Http\Request $request
     * @return void
     */
    public function validateKey(Request $request)
    {

        $id = $request->id;

        $token = rtrim($request->token, '/');
        $index = rtrim($request->index, '/');

        $key = \App\Key::find($index)->value;

        $t = openssl_encrypt($key, 'AES-128-ECB', base64_encode($id));
        $t = hash('sha256', $t);


        if(strcmp($t, $token) == 0){
            session('id', $index);
            session('token', $token);
            return redirect('dashboard');
        }
        else
            return back()->withInput()->withErrors(['empNum' => 'Invalid ID. Please input your Horsepower ID.']);
    }
    	
}
