@extends('layout')

@section('title')
  Horsepower - Exam Results
@endsection

@section('content')
  <div class="container content">
    <center>
      <h2 style="padding-bottom:20px">New Hire/s with Progress <span class="glyphicon glyphicon-download-alt pull-right"> </span></h2>
    </center>

    <table id='tb' class="table table-bordered display" cellspacing='0' width='100%'>
      <thead>
        <tr>
          <th scope="col">Last Update</th>
          <th scope="col">Name</th>
          <th scope="col">Email</th>
          <th scope="col">Progress</th>
        </tr>
      </thead>
      <tbody>
        @foreach($data as $d)
          <tr>
            <td>{{$d['date']}}</td>
            <td><a href="data/{{$d['id']}}">{{$d['name']}}</a></td>
            <td>{{$d['email']}}</td>
            <td>{{$d['progress']}}</td>
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
            });
      })
    </script>

@endsection