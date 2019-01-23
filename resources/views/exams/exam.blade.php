@extends('layout')

@section('title')
Electical Exam - Level {{session('page')}}
@endsection

@section('content')

    <div class="container content">
        <div class="panel panel-default">
            <div class="panel-heading">
                <center>


                <h1> {{$data->description->title}} </h1>
                <h4> {{$data->description->subtitle}} </h4>

                </center>
            </div>
            <div class="panel-body">
                <form class="form-horizontal" id="examForm" role="form" method="POST" action="{{ route('submitExam', ['level' => session('page')]) }}">
                    
                {{ csrf_field() }}
                
              

                <div class="col-lg-12">
                    <center>
                        @foreach($data->questions as $q)
                            <div class="col-lg-12"><h3 name="{{$q->name}}">{{$q->label}}</h3></div>
                            @foreach($q->choices as $choice)
                                <div class="col-lg-6">
                                    <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="radio" name="{{$q->name}}" value="{{$choice->value}}">
                                        {{$choice->label}}
                                    </label>
                                    </div>
                                </div>
                            @endforeach

                            <div class="col-lg-12"><hr></div>
                        @endforeach

                        <div class="col-lg-12">
                            <button type="submit">Submit</button>
                        </div>

                        <div class="col-lg-12"><br></div>
                    </center>
                </div>

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