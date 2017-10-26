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

    }
    
    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id Employee ID.
     * @param int $token Login token of employee.
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
     * @param int $id Employee ID.
     * @param int $token Login token of employee.
     * @return \Illuminate\Http\Response
     */
    public function getValidateView($id, $token)
    {
        $key = Key::where('token', '=', $token)->first();

        session()->put('generate_throttle', 0);

        if($key)
            return view('auth.validate', ['id' => $id, 'token' => $token]);
        else
            return redirect('error');
    }
    
    /**
     * Get error view.
     *
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function getGenerateView(Request $request)
    {

        if(!session()->has('ultipro_token')){
            $token = false;
            while($token == false)
                $token = UltiPro::login();
            session()->put('ultipro_token', $token);
        }
        return view('admin.generate');
    }

    /**
     * Get view for admin employee overview.
     * 
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

    /**
     * Generate key for new hire.
     *
     * @param Illuminate\Http\Request $request
     * @return void
     */
    public function generateKey(Request $request)
    {
        $request->validate([
            'id' => 'required',
        ]);

        if(session('generate_throttle') > 5){
            $error = 'Too many login attempts.';
            return back()->withInput()->withErrors(['email' => $error]);
        }

        if(session()->has('index') && session()->has('token')){
            return redirect('dashboard');
        }

        $id = $request->id;
        $flag = 0;

        if(is_numeric($request->id))
            $emp = UltiPro::validateId($id);
        else{
            $emp = UltiPro::validateEmail($id);
            $flag = 1;
        }

        $error = '';

        if($emp){
            $email = '';
            if($flag){
                $email = $id;
                $id = $emp["EmployeeNumber"];
            }
            else{
                $id = $request->id;
                $email = $emp["EmailAddress"];
            }

            $empl = Key::where('empid', $id)->first();

            if(!is_null($empl))
                $error = "There is a token assigned to this employee. Please contact the system administrator.";
            else{
                $rand = str_random(32);
                $token = openssl_encrypt($rand, 'AES-128-ECB', base64_encode($id));
                $token = hash('sha256', $token);

                $key = new Key;
                $key->value = $rand;
                $key->token = $token;
                $key->empid = $id;
                $key->full_name = $emp['FirstName'] . ' ' . $emp['LastName'];
                $key->save();

                // $msg = 'Your Horsepower employee number is '. $id .'. Please click on this link '. getenv('URL_PREFIX') .'/token/'.$key->id.'/'.$token.' to finish your enrollment.';

                // \Mail::raw($msg, function($message) use($email)
                // {
                //     $message->subject('Horsepower - Onboarding Todo List');
                //     $message->to($email);
                //     $message->from('no-reply@horsepowernyc.com', 'Horsepower Electric');
                // });

                return redirect()->route('queryvalidate', ['id' => $key->empid, 'token' => $key->token, 'index' => $key->id]);
                return view('admin.success');
            }
        }
        else
            $error = 'Invalid employee.';

        $throttle = session('generate_throttle');
        session()->put('generate_throttle', session()->get('generate_throttle') + 1);

        return back()->withInput()->withErrors(['email' => $error]);

    }

    /**
     * Validates the key input.
     * 
     * @param  Illuminate\Http\Request $request
     * @return void
     */
    public function validateKey(Request $request)
    {
        if(($request->query('id') !== null) && ($request->query('token') !== null) && ($request->query('index') !== null)){
            $id = $request->query('id');
            $token = $request->query('token');
            $index = $request->query('index');
        }
        else{
            if(is_null($request->id))
                return view('auth.error', ['msg' => 'Invalid token.']);

            $id = $request->id;
            $token = rtrim($request->token, '/');
            $index = rtrim($request->index, '/');
        }

        $key = Key::find($index);

        if(!$key){
            return view('auth.error', ['msg' => 'Invalid token.']);
        }

        if($key->throttle < 10)
        {
            $value = $key->value;

            $t = openssl_encrypt($value, 'AES-128-ECB', base64_encode($id));
            $t = hash('sha256', $t);

            if(strcmp($t, $token) == 0){
                session(['index' => $index]);
                session(['token' => $token]);
                session(['empid' => $key->empid]);
                session(['progress' => $key->progress]);

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
    	
}
