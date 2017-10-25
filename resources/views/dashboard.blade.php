@extends('layout')

@section('title')
	Horsepower - Home
@stop

@section('content')
    <div class="container content">
        <center>
            <div class="col-lg-12">
                <h1>To Do List</h1>
            </div>
        	<br>
            <div class="col-lg-12">
                <a href="reg/english" class="btn btn-default"><h5>
                    @if(session('emp_reg') > 0)
                        <span style="color:red" class="glyphicon glyphicon-exclamation-sign"></span>
                    @else
                        <span style="color:green" class="glyphicon glyphicon-ok-circle"></span>
                    @endif
                Request for Employee Registration</h5></a>
                
            </div>
            <div class="col-lg-12"><br></div>
            <div class="col-lg-12">
                <a href="bf/english" class="btn btn-default"><h5>
                    @if(session('build_trade') > 0)
                        <span style="color:red" class="glyphicon glyphicon-exclamation-sign"></span>
                    @else
                        <span style="color:green" class="glyphicon glyphicon-ok-circle"></span>
                    @endif
                Building Trades Benefit Funds Enrollment</h5></a>
            </div>
            <div class="col-lg-12"><br></div>
            <div class="col-lg-12">
                <a href="files" class="btn btn-default"><h5>
                    @if(session('files') > 0)
                        <span style="color:red" class="glyphicon glyphicon-exclamation-sign"></span>
                    @else
                        <span style="color:green" class="glyphicon glyphicon-ok-circle"></span>
                    @endif
                Upload Files</h5></a>
            </div>
        </center>
    </div>

@stop
