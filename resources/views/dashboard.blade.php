@extends('layout')

@section('title')
	Horsepower - Webapp Dashboard
@stop

@section('content')
    <div class="container content">
        <center>
            <div class="col-lg-12" style="padding-bottom: 20px">
                <h1>To do Progress</h1>
                <h6>@if(isset($next)) Next: {{$next}} @else Completed Registration @endif</h6>
            </div>
            <div class="col-lg-12">
                <div class="progress">
                    <div class="progress-bar" role="progressbar" aria-valuenow="{{$value}}" aria-valuemin="{{$value}}" aria-valuemax="100" style="width:{{$value}}%">
                    </div>
                </div>

                @if(isset($route))<a href={{route($route, $lang)}} class="btn btn-default">Go to {{$next}}</a>@endif
            </div>
        </center>
    </div>

@stop
