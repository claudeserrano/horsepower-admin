<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Facades\App\Services\UltiPro;
use \App\Key;

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
        if(session()->has('index') && session()->has('token')){
            return redirect('dashboard');
        }
        else{
            if(is_null($token) || is_null($id))
                return redirect('error');
            else{
                return redirect('validateview', ['id' => $id, 'token' => $token]);
            }
        }
    }
    
    /**
     * Get validate token view.
     *
     * @return \Illuminate\Http\Response
     */
    public function getValidateView($id, $token)
    {
        $key = Key::where('token', '=', $token)->first();

        if($key)
            return view('auth.validate', ['id' => $id, 'token' => $token]);
        else
            return redirect('error');
    }
    
    /**
     * Get error view.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function getErrorView()
    {
        $msg = "Something went wrong.";
        return view('auth.error', ['msg' => $msg]);
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
        \Mail::raw('test', function($message)
        {
            $message->subject('Horsepower - Onboarding Todo List');
            $message->to('claude@horsepowernyc.com');
            $message->from('no-reply@horsepowernyc.com', 'Horsepower Electric');
        });

        return;

        $id = $request->id;
        $emp = UltiPro::validateId($id);

        $error = '';

        if($emp){
            $empl = Key::where('empid', $request->id)->first();

            if(!is_null($empl))
                $error = "There is a token assigned to this employee.";
            else{
                $rand = str_random(32);
                $token = openssl_encrypt($rand, 'AES-128-ECB', base64_encode($id));
                $token = hash('sha256', $token);

                $key = new Key;
                $key->value = $rand;
                $key->token = $token;
                $key->empid = $emp['EmployeeIdentifier']['EmployeeNumber'];
                $key->full_name = $emp['FirstName'] . ' ' . $emp['LastName'];
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

        $key = Key::find($index);
        if($key->throttle < 10)
        {
            $value = $key->value;

            $t = openssl_encrypt($value, 'AES-128-ECB', base64_encode($id));
            $t = hash('sha256', $t);

            if(strcmp($t, $token) == 0){
                session(['index' => $index]);
                session(['token' => $token]);
                session(['empid' => $key->empid]);
                session(['emp_reg' => $key->emp_reg]);
                session(['build_trade' => $key->build_trade]);
                session(['files' => $key->files]);
                session(['gov_id' => $key->gov_id]);
                session(['ssn' => $key->ssn]);
                session(['bank' => $key->bank]);

                return redirect('dashboard');
            }
            else{
                $key->throttle++;
                $key->save();
                return back()->withInput()->withErrors(['empNum' => 'Invalid ID. Please input your Horsepower ID.']);
            }
        }
        else
            return back()->withInput()->withErrors(['empNum' => 'This token expired. Please ask system administrator for a new token.']);

    }

    /**
     * Get view for admin employee overview.
     * 
     * @param  Illuminate\Http\Request $request
     * @return Illuminate\Htpp\Response
     */
    public function getNewEmployeesView()
    {
        $keys = Key::all();

        return view('admin.employees', ['keys' => $keys]);

    }

    /**
     * Get all new employees.
     * 
     * @return json
     */
    public function getNewEmployees()
    {

        $keys = Key::all();
        return json_encode($keys);
        
    }
    	
}
