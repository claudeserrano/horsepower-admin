@extends('layout')

@section('title')
    HPE Electrician Exams
@stop

@section('content')

    <div class="container content">

      <div class="panel panel-default">
          <div class="panel-heading">
              <center>
              <h2> Please type your name then select the type of exam to start: </h2>
              </center>
          </div>
          <div class="panel-body">

            <form class="form-horizontal" role="form" method="POST" action="{{ route('startExam') }}">
            
            {{ csrf_field() }}

            <center>
            <h3>Full Name</h3>
            <input class="form-check-input" type="text" style="width:50%" name="name">

            @if($errors->has('name'))
              <p class="red">Please input your full name.</p>
            @endif

            <hr>

            <!--button type='submit' class="btn btn-default" name='type' value='helper'><h4>Experienced Helper</h4></button>
            <button class="btn btn-default" name='type' value='jrmech'><h4>Junior Mechanic</h4></button>
            <button class="btn btn-default" name='type' value='mech'><h4>Mechanic</h4></button-->

            <button class="btn btn-default" name='type' value='start'><h4>Start Exam</h4></button>

          </center>
          </div>

          </form>

      </div>
               
    </div>
 @stop

@section('scripts')
    <script>
       $(document).keypress(
           function(event){
            if (event.which == '13') {
               event.preventDefault();
             }
       });
    </script>
@endsection