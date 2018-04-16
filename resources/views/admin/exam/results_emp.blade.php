@extends('layout')

@section('title')
  Horsepower - Exam Results
@endsection

@section('content')
    <div class="container content">
        <div class="panel panel-default">
            <div class="panel-heading">
                <center>
                <h1> Examination Results </h1>
                <h4> {{$guest->name}}</h4>
                </center>
            </div>
            <div class="panel-body">
                <div class="col-lg-6">
                  <center>
                    @foreach($scores as $score)
                        <div class="panel panel-default">
                            <div class="panel-heading">
                              <h4>Electrician Exam Level {{$score->level}}</h4>
                            </div>
                            <div class="panel-body">
                              <h4><b>Score :</b> {{number_format($score->score,2)}} %</h4>
                            </div>
                        </div>
                    @endforeach
                </center>
                </div>
                <div class="col-lg-6">
                  <center>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                          <h4>Classification Exam</h4>
                        </div>
                        <div class="panel-body">
                          @foreach($class as $c)
                            <h4><b>Year {{$c['year']}} :</b> {{$c['correct']}} %</h4> <hr>
                          @endforeach
                        </div>
                    </div>
                </center>

                <a class="btn btn-default" href="{{URL::previous()}}">Back</a>
                </div>
            </div>
        </div>
  </div>
@endsection