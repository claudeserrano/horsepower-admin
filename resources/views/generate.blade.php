@extends('layout')

@section('title')
	Horsepower - Generate Keys for Employees 
@stop

@section('content')
 	<div class="container content">
 		<div class="col-lg-10 col-lg-offset-1">
			<center>
				<form class="form-horizontal" role="form" method="POST" action="{{ route('generate', ['access' => session('access')] ) }}">
				
				{{ csrf_field() }}
				<h2>Enter your email address @if(isset($access)) and full name @endif below	:</h2>
				<br>
				@if(isset($access))
					<div class="col-lg-6 col-lg-offset-3">
					    {!! Form::text('full_name', '',
					        ['class' => 'form-control',
					       	 'placeholder' => 'Full Name'
					        ]) 
					    !!}
					    @if($errors->has('full_name'))
					        <p class="red">{{$errors->first('full_name')}}</p>
					    @endif
					</div>
				@endif
				<div class="col-lg-6 col-lg-offset-3">
				    {!! Form::email('id', '',
				        ['class' => 'form-control email',
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