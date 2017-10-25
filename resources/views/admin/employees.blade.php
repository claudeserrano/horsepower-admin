@extends('layout')

@section('title')
	Horsepower - Admin Employee Check
@endsection

@section('content')
	<div class="container content">
		<center>
			<h2 style="padding-bottom:20px">Employees in System</h2>
		</center>

		<table id='tb' class="table table-bordered display" cellspacing='0' width='100%'>
			<thead>
				<tr>
					<th>Full Name</th>
					<th>Employee Number</th>
					<th>Progress</th>
				</tr>
			</thead>
			<tbody>
				@foreach($keys as $key)
					<tr>
						<td>{{ $key->full_name }}</td>
						<td>{{ $key->empid }}</td>
						<td>@if($key->progress == 0) Request for Employee Registration @elseif($key->progress == 1) Building Trades Benefit Funds Enrollment @elseif($key->progress == 2) Upload Required Files @else Completed @endif</td>
					</tr>
				@endforeach
			</tbody>
		</table>
	</div>
@endsection

@section('scripts')

    <script>
    	$(document).ready(function(){

            tb = $("#tb").DataTable({
            	"language": { "emptyTable": "No employees found." },
            	"columnDefs": [
            		{ "width": "40%", "targets": 0 },
            		{ "width": "20%", "targets": 1 },
            		{ "width": "40%", "targets": 2 },
            	]
            });
    	})
    </script>

@endsection