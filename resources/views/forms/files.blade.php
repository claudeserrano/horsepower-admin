@extends('layout')

@section('title')
	Horsepower - {{$lang->upload_files}}
@stop

@section('content')
    <div class="container content">
        <center>
            <div class="col-lg-12" style="padding-bottom:20px">
                <h1>{{$lang->upload_files}}</h1>
                <a href="form/lang/{{$lang->alt}}" class="btn btn-primary"><h6>{{$lang->alt_text}}</h6></a>
            </div>
            <form class="form-horizontal" enctype="multipart/form-data" role="form" method="POST" action="{{ route('submitForm', ['form' => 'files']) }}">
            
                {{ csrf_field() }}

                <div class="col-lg-12">
                    <div class="panel-danger panel" id="main">
                        <div class="panel-heading"><h3>{{$lang->required}}</h3></div>
                        <div class="panel-body">
                            <div class="col-lg-4">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <span style="color:red" class="glyphicon glyphicon-exclamation-sign"></span>
                                        {{$lang->gov_id}}
                                    </div>
                                    <div class="panel-body">
                                        <input type="file" accept="image/*" name="id" id="id" class="form-control-file mandatory"/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <span style="color:red" class="glyphicon glyphicon-exclamation-sign"></span>
                                        {{$lang->ssc}}
                                    </div>
                                    <div class="panel-body">
                                        <input type="file" accept="image/*" name="ssn" id="ssn" class="form-control-file mandatory"/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <span style="color:red" class="glyphicon glyphicon-exclamation-sign"></span>
                                        {{$lang->bank_statement}}
                                    </div>
                                    <div class="panel-body">
                                        <input type="file" accept="image/*" name="dd" id="dd" class="form-control-file mandatory"/>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4 col-lg-offset-2">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <span style="color:red" class="glyphicon glyphicon-exclamation-sign"></span>
                                        OSHA-10/OSHA-30
                                    </div>
                                    <div class="panel-body">
                                        <input type="file" accept="image/*" name="osha" id="osha" class="form-control-file mandatory"/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <span style="color:red" class="glyphicon glyphicon-exclamation-sign"></span>
                                        Scaffold Safety Certificate
                                    </div>
                                    <div class="panel-body">
                                        <input type="file" accept="image/*" name="scaffold" id="scaffold" class="form-control-file mandatory"/>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-2"></div>

                            <div class="col-lg-12">
                                <h6>* Items with an exclamation mark is mandatory</h6>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class=" panel-info panel">
                        <div class="panel-heading"><h5>{{$lang->if_perm_res}}</h5></div>
                        <div class="panel-body">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    {{$lang->green_card}}
                                </div>
                                <div class="panel-body">
                                    <input type="file" accept="image/*" name="greencard" id="greencard" class="form-control-file"/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h5>
                            {{$lang->if_wife_kids}}
                            </h5>
                        </div>
                        <div class="panel-body">
                            <div class="col-lg-6">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        {{$lang->marriage_cert}}
                                    </div>
                                    <div class="panel-body">
                                        <input type="file" accept="image/*" name="marriage" id="marriage" class="form-control-file"/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        {{$lang->birth_cert}}
                                    </div>
                                    <div class="panel-body">
                                        <input type="file" accept="image/*" name="birth[]" id="birth" multiple="" class="form-control-file"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h5>
                            {{$lang->cert}}
                            </h5>
                        </div>
                        <div class="panel-body">
                            <div class="col-lg-12" style="padding-bottom: 15px">
                                <button class="btn btn-default" id="add_cert"><span class="glyphicon glyphicon-plus"></span> {{$lang->add_cert}} </button>
                            </div>

                            <div class="col-lg-12" id="certificates">
                                <table id="cert_tb" class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12">
                    <button id="submit" type="submit" class="btn btn-default" disabled>Done</button>
                </div>
            </form>
        </center>
    </div>
@stop

@section('scripts')
    <script>
        function checkfiles(){
            var allow = 1;
            var submit = $('#submit');
            $(".mandatory").each(function(){
                if(!$(this).val())
                    allow = 0;
            });

            if(allow){
                submit.attr("disabled", false);
                $("#main").removeClass("panel-danger").addClass("panel-info");
            }
            else{
                submit.attr("disabled", true);
                $("#main").removeClass("panel-info").addClass("panel-danger");
            }

            return true;
        }

        $(document).ready(function(){
            $('.mandatory').on("change", function(){
                if(checkfiles())
                    $(this).parent().prev().find('span').attr({class:'glyphicon glyphicon-ok-circle', style:'color:green'})
                else
                    $(this).parent().prev().find('span').attr({class:'glyphicon glyphicon-exclamation-sign', style:'color:red'})
            })

            var cert_index = 1;

            $('#add_cert').click(function(event){
                event.preventDefault();
                $('#cert_tb > tbody:last-child').append('<tr id="'+cert_index+'"><td style="width:20%"><button class="btn btn-danger btn-remove-row" style="width:100%;height:100%" target="'+cert_index+'"><span class="glyphicon glyphicon-minus"></span> Remove </button></td><td style="width:80%"><center><input type="file" accept="image/*" name="cert'+cert_index+'" id="cert'+cert_index+'" class="form-control-file"/></center></td></tr>');
                cert_index++;
            });

            $(document).on("click",".btn-remove-row", function(){
                event.preventDefault();
                id = $(this).attr('target');
                $('#'+id).remove();
             });
        });
    </script>
@stop
