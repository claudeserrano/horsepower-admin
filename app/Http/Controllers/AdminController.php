<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Guest;

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
        $answers = $final->answers;

        for($i = 0; $i <= 4; $i++){
            $temp = 0;
            for($a = 1; $a <= 3; $a++){
                $temp += $answers->where('question', '=', $a + (3 * $i))->first()->correct;
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
            array_push($data, ['id' => $guest->id, 'name' => $guest->name, 'email' => $guest->information->Email, 'progress' => $guest->progress]);
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

}
