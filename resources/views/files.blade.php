@extends('layout')

@section('title')
	Horsepower - Personal Files Upload
@stop

@section('content')
    <div class="container content">
        <center>
            <div class="col-lg-12">
                <h1>Please upload the following files:</h1>
            </div>


            <form class="form-horizontal" enctype="multipart/form-data" role="form" method="POST" action="{{ route('upload') }}">
            
                {{ csrf_field() }}

                <div class="col-lg-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <span style="color:red" class="glyphicon glyphicon-exclamation-sign"></span>
                            Government Issued I.D.
                        </div>
                        <div class="panel-body">
                            <input type="file" accept=".jpg,.png" name="id" id="id" class="form-control-file"/>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <span style="color:red" class="glyphicon glyphicon-exclamation-sign"></span>
                            Green Card
                        </div>
                        <div class="panel-body">
                            <input type="file" accept=".jpg,.png" name="greencard" id="greencard" class="form-control-file"/>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <span style="color:red" class="glyphicon glyphicon-exclamation-sign"></span>
                            Social Securtiy Card
                        </div>
                        <div class="panel-body">
                            <input type="file" accept=".jpg,.png" name="ssn" id="ssn" class="form-control-file"/>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <span style="color:red" class="glyphicon glyphicon-exclamation-sign"></span>
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
                            <span style="color:red" class="glyphicon glyphicon-exclamation-sign"></span>
                            Scaffold Safety Certificate
                        </div>
                        <div class="panel-body">
                            <input type="file" accept=".jpg,.png" name="scaffold" id="scaffold" class="form-control-file"/>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <span style="color:red" class="glyphicon glyphicon-exclamation-sign"></span>
                            Bank Statement
                        </div>
                        <div class="panel-body">
                            <input type="file" accept=".jpg,.png" name="dd" id="dd" class="form-control-file"/>
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
                                        <input type="file" accept=".jpg,.png" name="birth" id="birth" class="form-control-file"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12">
                    <button id="submit" type="submit" class="btn btn-default" >Submit</button>
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
            $("input[type='file']").each(function(){
                if(!$(this).val())
                    allow = 0;
            });

            if(allow)
                submit.attr("disabled", false);
            else
                submit.attr("disabled", true);
        }

        $(document).ready(function(){
            $('input[type="file"]').on("change", function(){
                if($(this).val())
                    $(this).parent().prev().find('span').attr({class:'glyphicon glyphicon-ok-circle', style:'color:green'})
                else
                    $(this).parent().prev().find('span').attr({class:'glyphicon glyphicon-exclamation-sign', style:'color:green'})
                // checkfiles();
            })

            if($('#error').val())
                alert($('#error').val())
        });
    </script>
@stop
