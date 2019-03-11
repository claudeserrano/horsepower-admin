@extends('layout')

@section('title')
  Horsepower - Forms for {{$guest->name}}
@endsection

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <div class="container content">
        <div class="panel panel-default">
            <div class="panel-heading">
                <center>
                <h1>{{$guest->name}}</h1>
                </center>
            </div>
            <div class="panel-body">
              <center>
                <h4> Progress : {{$guest->progress}} </h4>
                <br/>

                <table class="table">
                  <thead>
                    <tr>
                      <th scope="col"> School Registration </th>
                      <th scope="col"> Build Trades Benefits  </th>
                      <th scope="col"> Union Local 363 </th>
                      <th scope="col"> Uploaded Files </th>
                    </tr>
                  </head>
                  <tbody>
                    <tr>
                      <td>@if(isset($guest->information)) <button class="btn btn-default generate" href="/" value="reg">Download</button> @else Pending @endif</td>
                      <td>@if(isset($guest->bf)) <button class="btn btn-default generate" href="/" value="bf">Download</button> @else Pending @endif</td>
                      <td>@if(isset($guest->union)) <button class="btn btn-default generate" href="/" value="union">Download</button> @else Pending @endif</td>
                      <td>@if($guest->progress >= 4) Download @else Pending @endif</td>
                    </tr>
                  </tbody>
                </table>
                
                <a class="btn btn-default" href="{{$guest->id}}/generate">Generate Files</a>
                <a class="btn btn-default" href="{{URL::previous()}}">Back</a>
              </center>
            </div>
        </div>
  </div>
@endsection

@section('scripts')
  {{ Html::script('js/forms.js') }}
@endsection