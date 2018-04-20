<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Guest;
use App\Score;
use App\Answer;
use Facades\App\Services\ExamHelper;

class ExamController extends Controller
{
 
 	private $validate = true;

	/**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('exam');
    }

    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->session()->has('started'))
            return redirect('exam/resume');
    	return view('exams.home');
    }

    /**
     * Process name and return exam page/s.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function start(Request $request)
    {
        $request->validate(['name' => 'required']);

        session(['started' => 1]);

        $examList = ExamHelper::getExamList($request->type);

        $guest = new Guest;
        $guest->name = $request->name;
        $guest->progress = 0;
        $guest->type = $request->type;
        $guest->save();

        session(['id' => $guest->id]);
        session(['list' => $examList]);
        session(['progress' => 0]);
        session(['page' => session('list')[session('progress')]]);
        session(['pages' => sizeof($examList)]);

        return redirect('exam');

    }

    /**
     * Submit exam data.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function submit(Request $request)
    {

        $level = $request->query('level');

        $scr = new Score;
        $scr->level = $level;
        $scr->guest_id = session('id');
        $scr->save();

        $answers = ExamHelper::getKey($level);
        $score = 0;

        for($i = 1; $i <= sizeof($answers); $i++)
        {
            $index = 'ans' . $i;
            $correct = $answers[$i - 1];
            $answer = $request->$index;

            $ans = new Answer;
            $ans->score_id = $scr->id;
            $ans->answer = $request->$index;
            $ans->question = $i;
            $ans->correct = 0;

            if($correct == $answer){
                $score++;
                $ans->correct = 1;
            }

            $ans->save();

        }

        $score = $score / sizeof($answers) * 100;

        $scr->score = $score;
        $scr->save();

        $guest = Guest::find(session('id'));
        $guest->progress += 1;
        $guest->save();

        $progress = session('progress');
        session(['progress' => $progress + 1]);

        if(session('progress') < session('pages')){
            session(['page' => session('list')[session('progress')]]);
        }
        else{
            return redirect('exam/complete');
        }

        return view('exams.exam');

    }

    /**
     * Complete the exam, return view.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function complete(Request $request)
    {
        $request->session()->flush();
        session(['progress' => 0]);
        return view('exams.complete');
    }

    /**
     * Resumes exam if session data is found.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function resume(Request $request)
    {

        if(session('progress') < session('pages')){
            return view('exams.exam');
        }
        else{
            return redirect('exam/complete');
        }

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
        return redirect('exam');
    }

}
