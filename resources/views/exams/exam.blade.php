@extends('layout')

@section('title')
Electical Exam - Level {{session('page')}}
@endsection

@section('content')

    <div class="container content">
        <div class="panel panel-default">
            <div class="panel-heading">
                <center>

                <div class="progress">
                    <div class="progress-bar @if(session('progress') == sizeof(session('list'))) progress-bar-success @endif " role="progressbar" aria-valuenow="{{session('progress') / sizeof(session('list'))}}" aria-valuemin="0" aria-valuemax="100" style="width:{{sprintf("%.2f", session('progress')) / sprintf("%.2f", sizeof(session('list'))) * 100}}%">
                      <p style="color:black">
                        @if(session('progress') == session('pages')) Complete @else {{session('progress') . '/' . session('pages')}} @endif
                      </p>
                    </div>
                </div>

                <h1> Electrical Exam </h1>
                @if(session('page') == 4)
                        <h4> Final Level </h4>
                @else
                        <h4> Level {{session('page')}} </h4>
                @endif
                </center>
            </div>
            <div class="panel-body">
                <form class="form-horizontal" id="examForm" role="form" method="POST" action="{{ route('submitExam', ['level' => session('page')]) }}">
                    
                {{ csrf_field() }}

                @include('exams.templates.level' . session('page'))

                </form>
            </div>
        </div>
               
    </div>
@endsection

@section('scripts')
    
    <script>

        $("#examForm").submit(function(){
            var c = confirm("Submit and finalize answers?");
            return c;
        });
    </script>

@endsection