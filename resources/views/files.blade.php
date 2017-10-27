@extends('layout')

@section('title')
	Horsepower - Personal Files Upload
@stop

@section('content')
    <div class="container content">
        <center>
            <div class="col-lg-12" style="padding-bottom:20px">
                <h1>Please upload the following files:</h1>
            </div>
            <form class="form-horizontal" enctype="multipart/form-data" role="form" method="POST" action="{{ route('upload') }}">
            
                {{ csrf_field() }}

                <div class="col-lg-12">
                    <div class="panel-danger panel" id="main">
                        <div class="panel-heading"><h3>Required</h3></div>
                        <div class="panel-body">
                            <div class="col-lg-4">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <span style="color:red" class="glyphicon glyphicon-exclamation-sign"></span>
                                        Government Issued I.D.
                                    </div>
                                    <div class="panel-body">
                                        <input type="file" accept=".jpg,.png" name="id" id="id" class="form-control-file mandatory"/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <span style="color:red" class="glyphicon glyphicon-exclamation-sign"></span>
                                        Social Securtiy Card
                                    </div>
                                    <div class="panel-body">
                                        <input type="file" accept=".jpg,.png" name="ssn" id="ssn" class="form-control-file mandatory"/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <span style="color:red" class="glyphicon glyphicon-exclamation-sign"></span>
                                        Bank Statement
                                    </div>
                                    <div class="panel-body">
                                        <input type="file" accept=".jpg,.png" name="dd" id="dd" class="form-control-file mandatory"/>
                                    </div>
                                </div>
                            </div>

                            <h6>* Items with an exclamation mark is mandatory</h6>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class=" panel-info panel">
                        <div class="panel-heading"><h5>If you are a permanent resident, provide the information below.</h5></div>
                        <div class="panel-body">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    Green Card
                                </div>
                                <div class="panel-body">
                                    <input type="file" accept=".jpg,.png" name="greencard" id="greencard" class="form-control-file"/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-8">
                    <div class=" panel-info panel">
                        <div class="panel-heading"><h5>If you are a <b>field employee</b>, provide the information below.</h5></div>
                        <div class="panel-body">
                            <div class="col-lg-6">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        OSHA-10/OSHA-30
                                    </div>
                                    <div class="panel-body">
                                        <input type="file" accept=".jpg,.png" name="osha" id="osha" class="form-control-file"/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        Scaffold Safety Certificate
                                    </div>
                                    <div class="panel-body">
                                        <input type="file" accept=".jpg,.png" name="scaffold" id="scaffold" class="form-control-file"/>
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
                            If your wife and/or kids are to be included in health insurance plan, add the files below.
                            </h5>
                        </div>
                        <div class="panel-body">
                            <div class="col-lg-6">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        Marriage Certificate
                                    </div>
                                    <div class="panel-body">
                                        <input type="file" accept=".jpg,.png" name="marriage" id="marriage" class="form-control-file"/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        Birth Certificate/s
                                    </div>
                                    <div class="panel-body">
                                        <input type="file" accept=".jpg,.png" name="birth[]" id="birth" multiple="" class="form-control-file"/>
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
                            If you have more certification, please upload below.
                            </h5>
                        </div>
                        <div class="panel-body">
                            <div class="col-lg-12" style="padding-bottom: 15px">
                                <button class="btn btn-default" id="add_cert"><span class="glyphicon glyphicon-plus"></span>  Add Certificate </button>
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
                    <button id="submit" type="submit" class="btn btn-default" disabled>Submit</button>
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
        }

        $(document).ready(function(){
            $('.mandatory').on("change", function(){
                if($(this).val())
                    $(this).parent().prev().find('span').attr({class:'glyphicon glyphicon-ok-circle', style:'color:green'})
                else
                    $(this).parent().prev().find('span').attr({class:'glyphicon glyphicon-exclamation-sign', style:'color:green'})
                checkfiles();
            })

            if($('#error').val())
                alert($('#error').val())

            var cert_index = 1;

            $('#add_cert').click(function(event){
                event.preventDefault();
                $('#cert_tb > tbody:last-child').append('<tr id="'+cert_index+'"><td style="width:20%"><button class="btn btn-danger btn-remove-row" style="width:100%;height:100%" target="'+cert_index+'"><span class="glyphicon glyphicon-minus"></span> Remove </button></td><td style="width:80%"><center><input type="file" accept=".jpg,.png" name="cert'+cert_index+'" id="cert'+cert_index+'" class="form-control-file"/></center></td></tr>');
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
