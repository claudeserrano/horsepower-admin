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
            return redirect('exam/generate');
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

        //  Get list of exams to take
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

        return redirect('exam/generate');

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

        //  If score is more than 7 or it's the last exam
        if($score >= 70 || $guest->progress >= 3)
            $guest->progress += 1;
        //  Skip to school exam
        else{
            $guest->progress = 3;
        }

        $guest->save();

        //  $progress = session('progress');
        //  session(['progress' => $progress + 1]);

        //  Put progress in session data
        session(['progress' => $guest->progress]);

        //  If progress is less than total pages, return exam page, else redirect to completion page
        if(session('progress') < session('pages')){
            session(['page' => session('list')[session('progress')]]);
        }
        else{
            return redirect('exam/complete');
        }

        return redirect('exam/generate');

    }

    /**
     * Complete the exam, return view.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function complete(Request $request)
    {
        //  If progress is less than total pages, return exam page, else redirect to completion page
        if(session('progress') < session('pages')){
            return redirect('exam/generate');
        }
        else{
            $request->session()->flush();
            session(['progress' => 0]);
            return view('exams.complete');
        }
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
     * Generates the exam view.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function generate(Request $request)
    {
        $file = 'exams/exam' . (session('progress') + 1) . '.json';
        $data = json_decode(file_get_contents($file));

        return view('exams.exam')->with(['data' => $data]);
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
