@extends('layout')

@section('title')Horsepower - {{$lang->request_emp_reg}}
@stop

@section('content')

        @foreach($errors as $error)
            {{$error}}asd
        @endforeach

        <div class="container content">

            <div class="col-lg-12"> 
                <center>
                    <h1>
                        {{$lang->request_emp_reg}}
                    </h1>
                    <a href="form/lang/{{$lang->alt}}" class="btn btn-primary"><h6>{{$lang->alt_text}}</h6></a>
                </center>
            </div>

            <div class="col-lg-12"><hr></div>

            <form class="form-horizontal" role="form" method="POST" action="{{ route('submitForm', ['form' => 'reg']) }}">
            
            {{ csrf_field() }}

            <div class="col-lg-12">

                <div class="col-lg-2">
                    <h4>{{$lang->last_name}}</h4>
                </div>
                <div class="col-lg-2">
                    {!! Form::text('LName', '',
                        ['class' => 'form-control',
                        ]) 
                    !!}


                    @if($errors->has('LName'))
                        <p class="red">Last name is required.</p>
                    @endif
                </div>

                <div class="col-lg-2">
                    <h4>{{$lang->first_name}}</h4>
                </div>
                <div class="col-lg-3">
                    {!! Form::text('FName', '',
                        ['class' => 'form-control',
                        ]) 
                    !!}

                    @if($errors->has('FName'))
                        <p class="red">First name is required.</p>
                    @endif
                </div>

                <div class="col-lg-2">
                    <h4>{{$lang->initials}}</h4>
                </div>
                <div class="col-lg-1">
                    {!! Form::text('MI', '',
                        ['class' => 'form-control',
                        ]) 
                    !!}
                </div>

                <div class="col-lg-12"></div>

                <div class="col-lg-4">
                    <h4>{{$lang->ssn}}</h4>
                </div>

                <div class="col-lg-8">
                    <div class="input-group">
                        {!! Form::text('SSN1', '',
                            ['class' => 'form-control',
                            'data-mask' => '000',
                            'placeholder' => 'xxx'
                            ]) 
                        !!}
                        <span class="input-group-addon" style="border-left: 0; border-right: 0;">-</span>
                        {!! Form::text('SSN2', '',
                            ['class' => 'form-control',
                            'data-mask' => '00',
                            'placeholder' => 'xx'
                            ]) 
                        !!}
                        <span class="input-group-addon" style="border-left: 0; border-right: 0;">-</span>
                        {!! Form::text('SSN3', '',
                            ['class' => 'form-control',
                            'data-mask' => '0000',
                            'placeholder' => 'xxxx'
                            ]) 
                        !!}
                    </div>
                </div>
                
                @if($errors->has('SSN1') || $errors->has('SSN2') || $errors->has('SSN3'))
                    <div class="col-lg-8 col-lg-offset-4 red">
                        Please input a valid social security number.
                    </div>
                @endif

                <div class="col-lg-12"></div>

                <div class="col-lg-12">
                    <h4>{{$lang->address}}</h4>
                </div>

                <div class="col-lg-2">
                    <h4>Street #</h4>
                </div>

                <div class="col-lg-1">
                    {!! Form::text('Number', '',
                        ['class' => 'form-control',
                        ]) 
                    !!}
                </div>

                <div class="col-lg-2">
                    <h4>{{$lang->street}}</h4>
                </div>

                <div class="col-lg-4">
                    {!! Form::text('Street', '',
                        ['class' => 'form-control',
                        ]) 
                    !!}
                </div>

                <div class="col-lg-2">
                    <h4>Apt. #</h4>
                </div>

                <div class="col-lg-1">
                    {!! Form::text('aptNo', '',
                        ['class' => 'form-control',
                         'maxlength' => '8'
                        ]) 
                    !!}
                </div>

                <div class="col-lg-12"></div>

                <div class="col-lg-1">
                    <h4>{{$lang->city}}</h4>
                </div>
                <div class="col-lg-3">
                    {!! Form::text('City', '',
                        ['class' => 'form-control',
                        ]) 
                    !!}

                    @if($errors->has('City'))
                        <p class="red">{{$errors->first('City')}}</p>
                    @endif
                </div>
                
                <div class="col-lg-1">
                    <h4>{{$lang->state}}</h4>
                </div>
                <div class="col-lg-3">
                    {!! Form::text('State', '',
                        ['class' => 'form-control',
                        ]) 
                    !!}

                    @if($errors->has('State'))
                        <p class="red">{{$errors->first('State')}}</p>
                    @endif
                </div>

                <div class="col-lg-1">
                    <h4>{{$lang->zip}}</h4>
                </div>
                <div class="col-lg-3">
                    {!! Form::number('Zip', '',
                        ['class' => 'form-control',
                        ]) 
                    !!}

                    @if($errors->has('Zip'))
                        <p class="red">{{$errors->first('Zip')}}</p>
                    @endif
                </div>

                <div class="col-lg-12"><br></div>

                <div class="col-lg-4">
                    <h4>{{$lang->tel_no}}</h4>
                </div>

                <div class="col-lg-8">
                    <div class="input-group">
                        <span class="input-group-addon">(</span>
                        {!! Form::text('AreaCode', '',
                            ['class' => 'form-control',
                            'data-mask' => '000',
                            'placeholder' => 'xxx'
                            ]) 
                        !!}
                        <span class="input-group-addon" style="border-left: 0; border-right: 0;">)</span>
                        {!! Form::text('TelNo1', '',
                            ['class' => 'form-control',
                            'data-mask' => '000',
                            'placeholder' => 'xxx'
                            ]) 
                        !!}
                        <span class="input-group-addon" style="border-left: 0; border-right: 0;">-</span>
                        {!! Form::text('TelNo2', '',
                            ['class' => 'form-control',
                            'data-mask' => '0000',
                            'placeholder' => 'xxxx'
                            ]) 
                        !!}
                    </div>
                </div>

                @if($errors->has('AreaCode') || $errors->has('TelNo1') || $errors->has('TelNo2'))
                    <div class="col-lg-8 col-lg-offset-4 red">
                        Please input a valid phone number.
                    </div>
                @endif

                <div class="col-lg-12"><br></div>

                <div class="col-lg-4">
                    <h4>{{$lang->cell_no}}</h4>
                </div>

                <div class="col-lg-8">
                    <div class="input-group">
                        <span class="input-group-addon">(</span>
                        {!! Form::text('AreaCodePhone', '',
                            ['class' => 'form-control',
                            'data-mask' => '000',
                            'placeholder' => 'xxx'
                            ]) 
                        !!}
                        <span class="input-group-addon" style="border-left: 0; border-right: 0;">)</span>
                        {!! Form::text('CellNo1', '',
                            ['class' => 'form-control',
                            'data-mask' => '000',
                            'placeholder' => 'xxx'
                            ]) 
                        !!}
                        <span class="input-group-addon" style="border-left: 0; border-right: 0;">-</span>
                        {!! Form::text('CellNo2', '',
                            ['class' => 'form-control',
                            'data-mask' => '0000',
                            'placeholder' => 'xxxx'
                            ]) 
                        !!}
                    </div>
                </div>

                @if($errors->has('AreaCodePhone') || $errors->has('CellNo1') || $errors->has('CellNo2'))
                    <div class="col-lg-8 col-lg-offset-4 red">
                        Please input a valid phone number.
                    </div>
                @endif

                <div class="col-lg-12"><br></div>

                <div class="col-lg-4">
                    <h4>{{$lang->dob}}</h4>
                </div>

                <div class="col-lg-8">
                    <div class="input-group">
                        {!! Form::text('DOBMonth', '',
                            ['class' => 'form-control',
                            'data-mask' => '00',
                            'placeholder' => 'mm'
                            ]) 
                        !!}
                        <span class="input-group-addon" style="border-left: 0; border-right: 0;">/</span>
                        {!! Form::text('DOBDay', '',
                            ['class' => 'form-control',
                            'data-mask' => '00',
                            'placeholder' => 'dd'
                            ]) 
                        !!}
                        <span class="input-group-addon" style="border-left: 0; border-right: 0;">/</span>
                        {!! Form::text('DOBYear', '',
                            ['class' => 'form-control',
                            'data-mask' => '0000',
                            'placeholder' => 'yyyy'
                            ]) 
                        !!}
                    </div>
                </div>

                @if($errors->has('DOBMonth') || $errors->has('DOBDay') || $errors->has('DOBYear'))
                    <div class="col-lg-8 col-lg-offset-4 red">
                        Please input a valid date of birth.
                    </div>
                @endif

                <div class="col-lg-12"></div>

                <div class="col-lg-4">
                    <h4>{{$lang->email}}</h4>
                </div>
                <div class="col-lg-8">
                    {!! Form::email('Email', '',
                        ['class' => 'form-control email',
                        ]) 
                    !!}
                </div>

                @if($errors->has('Email'))
                    <div class="col-lg-8 col-lg-offset-4 red">
                        {{$errors->first('Email')}}
                    </div>
                @endif

                <div class="col-lg-12"><br></div>

                <div class="col-lg-4">
                    <h4>{{$lang->start_date}}</h4>
                </div>

                <div class="col-lg-8">
                    <div class="input-group">
                        {!! Form::text('StartMonth', '',
                            ['class' => 'form-control',
                            'data-mask' => '00',
                            'placeholder' => 'mm'
                            ]) 
                        !!}
                        <span class="input-group-addon" style="border-left: 0; border-right: 0;">/</span>
                        {!! Form::text('StartDay', '',
                            ['class' => 'form-control',
                            'data-mask' => '00',
                            'placeholder' => 'dd'
                            ]) 
                        !!}
                        <span class="input-group-addon" style="border-left: 0; border-right: 0;">/</span>
                        {!! Form::text('StartYear', '',
                            ['class' => 'form-control',
                            'data-mask' => '0000',
                            'placeholder' => 'yyyy'
                            ]) 
                        !!}
                    </div>
                </div>

                @if($errors->has('StartMonth') || $errors->has('StartDay') || $errors->has('StartYear'))
                    <div class="col-lg-8 col-lg-offset-4 red">
                        Please input a valid date.
                    </div>
                @endif

                <div class="col-lg-12"></div>
                
                <div class="col-lg-4">
                    <h4>{{$lang->employer}}</h4>
                </div>

                <div class="col-lg-8">
                    {!! Form::text('Employer', 'Horsepower Electric',
                        ['class' => 'form-control', 'readonly' => true,
                        ]) 
                    !!}
                </div>

                <div class="col-lg-12"><br></div>

                <div class="col-lg-4">
                    <h4>{{$lang->ethnic_grp}}</h4>
                </div>
                
                <div class="col-lg-8">
                    <div class="form-check">
                      <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="EthnicGroup" id="exampleRadios1" value="Hispanic" checked>
                        {{$lang->hisp_or_lat}}
                      </label>
                    </div>
                    <div class="form-check">
                      <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="EthnicGroup" id="exampleRadios2" value="NonHispanic">
                        {{$lang->not_hisp_or_lat}}
                      </label>
                    </div>
                </div>

                <div class="col-lg-12"><br></div>

                <div class="col-lg-4">
                    <h4>{{$lang->race}}</h4>
                </div>
                
                <div class="col-lg-8">
                    <div class="form-check">
                      <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="Race" value="White" checked>
                        {{$lang->white}}
                      </label>
                    </div>
                    <div class="form-check">
                      <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="Race" value="AfricanAmerican">
                        {{$lang->afr_am}}
                      </label>
                    </div>
                    <div class="form-check">
                      <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="Race" value="Native">
                        {{$lang->nat_am}}
                      </label>
                    </div>
                    <div class="form-check">
                      <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="Race" value="Asian">
                        {{$lang->asian_pac}}
                      </label>
                    </div>
                    <div class="form-check">
                      <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="Race" value="Other">
                        {{$lang->other}}
                      </label>
                    </div>
                </div>

                <div class="col-lg-12"><br></div>

                <div class="col-lg-4">
                    <h4>{{$lang->sex}}</h4>
                </div>
                
                <div class="col-lg-8">
                    <div class="form-check">
                      <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="Sex" value="Male" checked>
                        {{$lang->male}}
                      </label>
                    </div>
                    <div class="form-check">
                      <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="Sex" value="Female">
                        {{$lang->female}}
                      </label>
                    </div>
                </div>

                <div class="col-lg-12"><br></div>

                <div class="col-lg-4">
                    <h4>Veteran</h4>
                </div>
                
                <div class="col-lg-8">
                    <div class="form-check">
                      <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="Veteran" value="Yes" checked>
                        {{$lang->yes}}
                      </label>
                    </div>
                    <div class="form-check">
                      <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="Veteran" value="No">
                        {{$lang->no}}
                      </label>
                    </div>
                </div>

                <div class="col-lg-12"><br></div>

                <div class="col-lg-12">
                    <center>
                    <div id="signature-pad" class="signature-pad">
                        <div class="signature-pad--body">
                            <canvas></canvas>
                        </div>
                        <div class="signature-pad--footer">
                            <div class="description">Sign above</div>
                            <div class="signature-pad--actions">
                                <div>
                                <button type="button" class="button clear" data-action="clear">{{$lang->clear}}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    </center>
                </div>

                <input type="hidden" name="uri" id="uri"></input>

                <div class="col-lg-12"><br></div>

                <div class="col-lg-12">
                    <div class="col-lg-4 col-lg-offset-4">
                        <center>
                        <button type="submit" onclick="signature()">{{$lang->submit}}</button>
                        </center>
                    </div>
                    <br><br>
                </div>

                </form>

            </div>
        </div>

@stop

@section('scripts')
    
    <script>
        var canvas = document.querySelector("canvas");

        var signaturePad = new SignaturePad(canvas);

        function signature(){
            var hidden = document.getElementById('uri');
            hidden.value = signaturePad.toDataURL();
        }

        $(document).ready(function(){
            $(document).on("click", "button[type='submit']", function(event){
                if(signaturePad.isEmpty()){
                    alert('Please input your signature.');
                    event.preventDefault();
                }
                else
                    signature();
            })
        });

    </script>
    
@endsection