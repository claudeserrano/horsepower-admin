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
                    <div class="progress-bar @if($index == 4) progress-bar-success @endif " role="progressbar" aria-valuenow="{{$value}}" aria-valuemin="{{$value}}" aria-valuemax="100" style="width:{{$value}}%">
                        @if($index == 4) Complete @else {{$index}} / 4 @endif
                    </div>

                    <div class="progress-bar @if($index == 3) progress-bar-success @endif " role="progressbar" aria-valuenow="{{$value}}" aria-valuemin="{{$value}}" aria-valuemax="100" style="width:{{$value}}%">
                        @if($index == 3) Complete @else {{$index}} / 3 @endif
                    </div>
                </div>

                @if(isset($route))<a href={{route($route, $lang)}} class="btn btn-default">Go to {{$next}}</a> @else <a href='https://onboarding.ultipro.com/HOR1009' class="btn btn-default">Return to Onboarding</a> @endif
            </div>
        </center>
    </div>

@stop
