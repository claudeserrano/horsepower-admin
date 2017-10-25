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
					<th>EMPREG</th>
					<th>BF</th>
					<th>GOVID</th>
					<th>SSN</th>
					<th>BANK</th>
				</tr>
			</thead>
			<tbody>
				@foreach($keys as $key)
					<tr>
						<td>{{ $key->full_name }}</td>
						<td>{{ $key->empid }}</td>
						<td>@if($key->emp_reg == 1) <span class="glyphicon glyphicon-remove"/> @else <span class="glyphicon glyphicon-ok"/> @endif</td>
						<td>@if($key->build_trade == 1) <span class="glyphicon glyphicon-remove"/> @else <span class="glyphicon glyphicon-ok"/> @endif</td>
						<td>@if($key->gov_id == 1) <span class="glyphicon glyphicon-remove"/> @else <span class="glyphicon glyphicon-ok"/> @endif</td>
						<td>@if($key->ssn == 1) <span class="glyphicon glyphicon-remove"/> @else <span class="glyphicon glyphicon-ok"/> @endif</td>
						<td>@if($key->bank == 1) <span class="glyphicon glyphicon-remove"/> @else <span class="glyphicon glyphicon-ok"/> @endif</td>						
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
            		{ "width": "8%", "targets": [2,3,4,5,6] },
            		{ "width": "40%", "targets": 0 },
            		{ "width": "20%", "targets": 1 },
            	]
            });
    	})
    </script>

@endsection