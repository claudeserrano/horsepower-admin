@extends('layout')

@section('title')
  Horsepower - Forms for {{$guest->name}}
@endsection

@section('content')
    <div class="container content">
        <div class="panel panel-default">
            <div class="panel-heading">
                <center>
                <h1>{{$guest->name}}</h1>
                </center>
            </div>
            <div class="panel-body">
              <center>
                <a class="btn btn-default" href="{{$guest->id}}/generate">Generate Files</a>
                <a class="btn btn-default" href="{{URL::previous()}}">Back</a>
              </center>
            </div>
        </div>
  </div>
@endsection