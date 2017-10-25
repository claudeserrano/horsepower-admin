@extends('layout')

@section('title')
	Horsepower - Authentication
@stop

@section('content')

 	<div class="container content">
 		<div class="col-lg-10 col-lg-offset-1">
			<center>
				<form class="form-horizontal" role="form" method="POST" action="{{ route('validate') }}">
				
				{{ csrf_field() }}

				<input type="hidden" name="index" value={{$id}}/>
				<input type="hidden" name="token" value={{$token}}/>

				<h2>Enter your employee ID below:</h2>
				
				<br>

				<div class="col-lg-6 col-lg-offset-3">
				    {!! Form::number('id', '',
				        ['class' => 'form-control',
				       	 'placeholder' => ''
				        ]) 
				    !!}
				    @if($errors->has('empNum'))
				        <p class="red">{{$errors->first('empNum')}}</p>
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