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
    
}
