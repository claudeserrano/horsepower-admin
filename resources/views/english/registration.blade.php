@extends('layout')

@section('title')Horsepower - Request for Employee Registration
@stop

@section('content')

        <div class="container content">

            <div class="col-lg-12"> 
                <center>
                    <h1>
                        Request for Employee Registration 
                    </h1>
                    <a href="spanish" class="btn btn-primary"><h6>To Spanish</h6></a>
                </center>
            </div>

            <div class="col-lg-12"><hr></div>

            <form class="form-horizontal" role="form" method="POST" action="{{ route('regpdf', ['lang' => 'English']) }}">
            
            {{ csrf_field() }}

            <div class="col-lg-12">

                {{-- <div class="col-lg-4">
                    <h4>Name</h4>
                </div>
                <div class="col-lg-8">
                    {!! Form::text('Name', '',
                        ['class' => 'form-control',
                        ]) 
                    !!}
                </div> --}}

                <div class="col-lg-2">
                    <h4>Last Name</h4>
                </div>
                <div class="col-lg-2">
                    {!! Form::text('LName', '',
                        ['class' => 'form-control',
                        ]) 
                    !!}
                </div>

                <div class="col-lg-2">
                    <h4>First Name</h4>
                </div>
                <div class="col-lg-3">
                    {!! Form::text('FName', '',
                        ['class' => 'form-control',
                        ]) 
                    !!}
                </div>

                <div class="col-lg-2">
                    <h4>Middle Initial</h4>
                </div>
                <div class="col-lg-1">
                    {!! Form::text('MI', '',
                        ['class' => 'form-control',
                        ]) 
                    !!}
                </div>
                
                {{-- @if($errors->has('Name'))
                    <div class="col-lg-8 col-lg-offset-4 red">
                        {{$errors->first('Name')}}
                    </div>
                @endif --}}

                <div class="col-lg-12"></div>

                <div class="col-lg-4">
                    <h4>Social Security Number</h4>
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

                {{-- <div class="col-lg-4">
                    <h4>Address (No. and Street)</h4>
                </div>

                <div class="col-lg-8">
                    {!! Form::text('Address1', '',
                        ['class' => 'form-control',
                        ]) 
                    !!}
                </div>

                @if($errors->has('Address1'))
                    <div class="col-lg-8 col-lg-offset-4 red">
                        The address field is required.
                    </div>
                @endif --}}

                <div class="col-lg-2">
                    <h4>Address</h4>
                </div>

                <div class="col-lg-2">
                    <h4>Number</h4>
                </div>

                <div class="col-lg-1">
                    {!! Form::text('Number', '',
                        ['class' => 'form-control',
                        ]) 
                    !!}
                </div>

                <div class="col-lg-2">
                    <h4>Street</h4>
                </div>

                <div class="col-lg-5">
                    {!! Form::text('Street', '',
                        ['class' => 'form-control',
                        ]) 
                    !!}
                </div>

                <div class="col-lg-12"></div>

                <div class="col-lg-1">
                    <h4>City</h4>
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
                    <h4>State</h4>
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
                    <h4>Zip</h4>
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
                    <h4>Telephone Number</h4>
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
                    <h4>Cellphone Number</h4>
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
                    <h4>Date of Birth</h4>
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
                    <h4>E-mail</h4>
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
                    <h4>Requested Start Date</h4>
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
                    <h4>Employer</h4>
                </div>

                <div class="col-lg-8">
                    {!! Form::text('Employer', 'Horsepower Electric',
                        ['class' => 'form-control', 'readonly' => true,
                        ]) 
                    !!}
                </div>

                <div class="col-lg-12"><br></div>

                <div class="col-lg-4">
                    <h4>Ethnic Group</h4>
                </div>
                
                <div class="col-lg-8">
                    <div class="form-check">
                      <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="EthnicGroup" id="exampleRadios1" value="Hispanic" checked>
                        Hispanic or Latino
                      </label>
                    </div>
                    <div class="form-check">
                      <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="EthnicGroup" id="exampleRadios2" value="NonHispanic">
                        Not Hispanic or Latino
                      </label>
                    </div>
                </div>

                <div class="col-lg-12"><br></div>

                <div class="col-lg-4">
                    <h4>Race</h4>
                </div>
                
                <div class="col-lg-8">
                    <div class="form-check">
                      <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="Race" value="White" checked>
                        White
                      </label>
                    </div>
                    <div class="form-check">
                      <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="Race" value="AfricanAmerican">
                        African American
                      </label>
                    </div>
                    <div class="form-check">
                      <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="Race" value="Native">
                        Native American or Alaskan Native
                      </label>
                    </div>
                    <div class="form-check">
                      <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="Race" value="Asian">
                        Asian or Pacific Islander
                      </label>
                    </div>
                    <div class="form-check">
                      <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="Race" value="Other">
                        Other
                      </label>
                    </div>
                </div>

                <div class="col-lg-12"><br></div>

                <div class="col-lg-4">
                    <h4>Sex</h4>
                </div>
                
                <div class="col-lg-8">
                    <div class="form-check">
                      <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="Sex" value="Male" checked>
                        Male
                      </label>
                    </div>
                    <div class="form-check">
                      <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="Sex" value="Female">
                        Female
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
                        Yes
                      </label>
                    </div>
                    <div class="form-check">
                      <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="Veteran" value="No">
                        No
                      </label>
                    </div>
                </div>

                {{-- <div class="col-lg-12"></div>

                <div class="col-lg-4">
                    <h4>Classification</h4>
                </div>
                <div class="col-lg-8">
                    {!! Form::text('Classification', '',
                        ['class' => 'form-control',
                        ]) 
                    !!}
                </div>

                @if($errors->has('Classification'))
                    <div class="col-lg-8 col-lg-offset-4 red">
                        {{$errors->first('Classification')}}
                    </div>
                @endif

                <div class="col-lg-12"></div>

                <div class="col-lg-4">
                    <h4>School Class</h4>
                </div>
                <div class="col-lg-8">
                    {!! Form::text('SchoolClass', '',
                        ['class' => 'form-control',
                        ]) 
                    !!}
                </div>

                @if($errors->has('SchoolClass'))
                    <div class="col-lg-8 col-lg-offset-4 red">
                        {{$errors->first('SchoolClass')}}
                    </div>
                @endif --}}

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
                                <button type="button" class="button clear" data-action="clear">Clear</button>
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
                        <button type="submit" onclick="signature()">Submit</button>
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