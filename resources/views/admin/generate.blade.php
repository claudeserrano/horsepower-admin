@extends('layout')

@section('title')
	Horsepower - Generate Keys for Employees 
@stop

@section('content')
 	<div class="container content">
 		<div class="col-lg-10 col-lg-offset-1">
			<center>
				<form class="form-horizontal" role="form" method="POST" action="{{ route('generate') }}">
				
				{{ csrf_field() }}
				<h2>Enter your email address below:</h2>
				<br>
				<div class="col-lg-6 col-lg-offset-3">
				    {!! Form::text('id', '',
				        ['class' => 'form-control',
				       	 'placeholder' => ''
				        ]) 
				    !!}
				    @if($errors->has('email'))
				        <p class="red">{{$errors->first('email')}}</p>
				    @endif

				    @if($errors->has('id'))
				        <p class="red">Please input an appropriate email address.</p>
				    @endif
				</div>

				<div class="col-lg-12" style="padding-top:30px">
				    <button type="submit" class="btn btn-default">Submit</button>
				    </div>
				</div>

				</form>
			</center>
		</div>
	</div>
@stop