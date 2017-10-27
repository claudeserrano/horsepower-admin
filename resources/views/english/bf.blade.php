@extends('layout')

@section('title')
    Horsepower - Building Trades Benefit Funds Enrollment
@stop

@section('content')

        <div class="container content">

            <div class="col-lg-12"> 
                <center>
                    <h1>
                        Building Trades Benefit Funds Enrollment
                    </h1>
                    <a class="btn btn-primary" href="spanish"><h6>To Spanish</h6></a>
                </center>
            </div>

            <form class="form-horizontal" role="form" method="POST" action="{{ route('bfpdf', ['lang' => 'English']) }}">
            
            {{ csrf_field() }}

            <input type="hidden" name="lang" value="1"/>

            <div class="col-lg-12">

                <div class="col-lg-12"><h3>Member's Full Name</h3></div>

                <div class="col-lg-2">
                    <h4>Last Name</h4>
                </div>
                <div class="col-lg-2">
                    {!! Form::text('LAST_NAME', '',
                        ['class' => 'form-control',
                        ])
                    !!}
                    @if($errors->has('LAST_NAME'))
                        <p class="red">Please input your last name.</p>
                    @endif
                </div>
                
                <div class="col-lg-2">
                    <h4>First Name</h4>
                </div>
                <div class="col-lg-3">
                    {!! Form::text('FIRST_NAME', '',
                        ['class' => 'form-control',
                        ])
                    !!}
                    @if($errors->has('FIRST_NAME'))
                        <p class="red">Please input your first name.</p>
                    @endif
                </div>

                <div class="col-lg-1">
                    <h4>Initials</h4>
                </div>
                <div class="col-lg-2">
                    {!! Form::text('INITIALS', '',
                        ['class' => 'form-control',
                        ]) 
                    !!}
                </div>

                <div class="col-lg-12"><br></div>

                <div class="col-lg-4">
                    <h4>Social Security Number</h4>
                </div>

                <div class="col-lg-8">
                    {!! Form::text('SSN', '',
                        ['class' => 'form-control ssn',
                        ]) 
                    !!}
                    @if($errors->has('SSN'))
                        <p class="red">{{$errors->first('SSN')}}</p>
                    @endif
                </div>

                <div class="col-lg-12"><br></div>

                <div class="col-lg-4">
                    <h4>Home or Cellphone Number</h4>
                </div>

                <div class="col-lg-8">
                    {!! Form::text('NUMBER', '',
                        ['class' => 'form-control phone',
                        ]) 
                    !!}
                </div>

                @if($errors->has('NUMBER'))
                    <div class="col-lg-8 col-lg-offset-4">
                        <p class="red">Please enter a valid phone number.</p>
                    </div>
                @endif

                <div class="col-lg-12"><br></div>

                <div class="col-lg-4">
                    <h4>Date of Birth</h4>
                </div>

                <div class="col-lg-8">
                    {!! Form::text('DOB', '',
                        ['class' => 'form-control date',
                        ]) 
                    !!}
                </div>

                @if($errors->has('DOB'))
                    <div class="col-lg-8 col-lg-offset-4">
                        <p class="red">Please enter a valid date.</p>
                    </div>
                @endif

                <div class="col-lg-12"><br></div>

                <div class="col-lg-4">
                    <h4>E-mail</h4>
                </div>

                <div class="col-lg-8">
                    {!! Form::email('EMAIL', '',
                        ['class' => 'form-control email',
                        ]) 
                    !!}
                </div>

                @if($errors->has('EMAIL'))
                    <div class="col-lg-8 col-lg-offset-4">
                        <p class="red">{{$errors->first('EMAIL')}}</p>
                    </div>
                @endif

                <div class="col-lg-12"><br></div>

                <div class="col-lg-3">
                    <h4>Sex</h4>
                </div>
                
                <div class="col-lg-3">
                    <div class="form-check">
                      <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="SEX" value="M" checked>
                        Male
                      </label>
                    </div>
                    <div class="form-check">
                      <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="SEX" value="F">
                        Female
                      </label>
                    </div>
                </div>

                <div class="col-lg-3">
                    <h4>Marital Status</h4>
                </div>
                
                <div class="col-lg-3">
                    <div class="form-check">
                      <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="STATUS" value="MARRIED" checked>
                        Married
                      </label>
                    </div>
                    <div class="form-check">
                      <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="STATUS" value="SINGLE">
                        Single
                      </label>
                    </div>
                    <div class="form-check">
                      <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="STATUS" value="DIVORCED">
                        Divorced
                      </label>
                    </div>
                    <div class="form-check">
                      <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="STATUS" value="WIDOW">
                        Widower
                      </label>
                    </div>
                </div>

                <div class="col-lg-12"><h3>Member's Address</h3></div>

                <div class="col-lg-2">
                    <h4>Street Address</h4>
                </div>

                <div class="col-lg-3">
                    {!! Form::text('STREET_ADDRESS', '',
                        ['class' => 'form-control',
                        ]) 
                    !!}
                    @if($errors->has('STREET_ADDRESS'))
                        <p class="red">Please input a street address.</p>
                    @endif
                </div>

                <div class="col-lg-2">
                    <h4>Apartment No</h4>
                </div>
                <div class="col-lg-1">
                    {!! Form::number('APT', '',
                        ['class' => 'form-control',
                        ]) 
                    !!}
                </div>

                <div class="col-lg-12"></div>
                
                <div class="col-lg-2">
                    <h4>City</h4>
                </div>
                <div class="col-lg-3">
                    {!! Form::text('CITY', '',
                        ['class' => 'form-control',
                        ]) 
                    !!}
                    @if($errors->has('CITY'))
                        <p class="red">Please input the city you reside in.</p>
                    @endif
                </div>
                
                <div class="col-lg-2">
                    <h4>State</h4>
                </div>
                <div class="col-lg-1">
                    {!! Form::text('STATE', '',
                        ['class' => 'form-control',
                        ]) 
                    !!}
                    @if($errors->has('STATE'))
                        <p class="red">Please input the state you reside in.</p>
                    @endif
                </div>

                <div class="col-lg-1">
                    <h4>Zip</h4>
                </div>
                <div class="col-lg-3">
                    {!! Form::number('ZIP', '',
                        ['class' => 'form-control',
                        ]) 
                    !!}
                    @if($errors->has('ZIP'))
                        <p class="red">Please input the zip where you reside in.</p>
                    @endif
                </div>

                <div class="col-lg-12"><br></div>
                
                <div class="col-lg-4">
                    <h4>Shop Name</h4>
                </div>

                <div class="col-lg-8">
                    {!! Form::text('SHOP_NAME', 'Horsepower Electric',
                        ['class' => 'form-control', 'readonly' => true,
                        ]) 
                    !!}
                </div>

                <div class="col-lg-12"><br></div>

                <div class="col-lg-4">
                    <h4>Job Class</h4>
                </div>

                <div class="col-lg-8">
                    {!! Form::text('JOB_CLASS', '',
                        ['class' => 'form-control',
                        ]) 
                    !!}
                </div>

                @if($errors->has('JOB_CLASS'))
                    <div class="col-lg-8 col-lg-offset-4">
                        <p class="red">Please input your job classification.</p>
                    </div>
                @endif

                <div class="col-lg-12"><br></div>

                <div class="col-lg-4">
                    <h4>Date Hired</h4>
                </div>

                <div class="col-lg-8">
                    {!! Form::text('DATE_HIRED', '',
                        ['class' => 'form-control date',
                        ]) 
                    !!}
                </div>

                @if($errors->has('DATE_HIRED'))
                    <div class="col-lg-8 col-lg-offset-4">
                        <p class="red">Please input a valid date.</p>
                    </div>
                @endif

                <div class="col-lg-12"><center><h3>Complete the following for your spouse, and all dependent children</h3></center></div>

                <div class="col-lg-12" style="min-width:700px">
                    <table class="table table-bordered">
                        <thead>
                            <td class="col-lg-1">#</td>
                            <td class="col-lg-4">Full Name</td>
                            <td class="col-lg-2">Date of Birth</td>
                            <td class="col-lg-1">Sex</td>
                            <td class="col-lg-2">SSN</td>
                            <td class="col-lg-2">Relationship</td>
                        </thead>
                        <tbody>
                            @for($i = 1; $i <= 8; $i++)
                                <tr>
                                    <td> {{$i}}</td>
                                    <td>
                                        {!! Form::text('FAMILY' . $i, '',
                                            ['class' => 'form-control',
                                            ]) 
                                        !!}
                                    </td>
                                    <td>
                                        {!! Form::text('FAMILY_DOB' . $i, '',
                                            ['class' => 'form-control date',
                                            ]) 
                                        !!}
                                        @if($errors->has('FAMILY_DOB' . $i))
                                            <p class="red">Please input a valid date.</p>
                                        @endif
                                    </td>
                                    <td>
                                        {!! Form::text('SEX' . $i, '',
                                            ['class' => 'form-control sex',
                                            ]) 
                                        !!}
                                    </td>
                                    <td>
                                        {!! Form::text('FAMILY_SSN' . $i, '',
                                            ['class' => 'form-control ssn',
                                            ]) 
                                        !!}
                                        @if($errors->has('FAMILY_SSN' . $i))
                                            <p class="red">Please input a valid social security number.</p>
                                        @endif
                                    </td>
                                    <td>
                                        {!! Form::text('FAMILY_RELATIONSHIP' . $i, '',
                                            ['class' => 'form-control',
                                            ]) 
                                        !!}
                                    </td>
                                </tr>
                            @endfor
                        </tbody>
                    </table>
                </div>

                <div class="col-lg-12"><center><h3>If married, complete this section</h3></center></div>

                <div class="col-lg-4">
                    <h4>Date Married</h4>
                </div>

                <div class="col-lg-8">
                    {!! Form::text('DATE_MARRIED', '',
                        ['class' => 'form-control date',
                        ]) 
                    !!}
                </div>

                @if($errors->has('DATE_MARRIED'))
                    <div class="col-lg-8 col-lg-offset-4">
                        <p class="red">Please input a valid date.</p>
                    </div>
                @endif

                <div class="col-lg-12"><br></div>

                <div class="col-lg-4">
                    <h4>City, State, and Country Married</h4>
                </div>

                <div class="col-lg-8">
                    {!! Form::text('PLACE_MARRIED', '',
                        ['class' => 'form-control',
                        ]) 
                    !!}
                </div>

                <div class="col-lg-12"><center><h3>If ever divorced or legally separated, complete this section</h3></center></div>

                <div class="col-lg-4">
                    <h4>Date of Divorce</h4>
                </div>

                <div class="col-lg-8">
                    {!! Form::text('DATE_DIVORCE', '',
                        ['class' => 'form-control date',
                        ]) 
                    !!}
                </div>

                @if($errors->has('DATE_DIVORCE'))
                    <div class="col-lg-8 col-lg-offset-4">
                        <p class="red">Please input a valid date.</p>
                    </div>
                @endif

                <div class="col-lg-12"><br></div>

                <div class="col-lg-4">
                    <h4>Is there a court order for you to provide health coverage for your dependents?</h4>
                </div>
                
                <div class="col-lg-8">
                    <div class="form-check">
                      <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="COURT_ORDER" value="Y">
                        Yes
                      </label>
                    </div>
                    <div class="form-check">
                      <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="COURT_ORDER" value="N">
                        No
                      </label>
                    </div>
                </div>

                <div class="col-lg-12"><center><h3>If your spouse is employed, complete this section</h3></center></div>

                <div class="col-lg-4">
                    <h4>Full Name of Spouse's Employer</h4>
                </div>

                <div class="col-lg-8">
                    {!! Form::text('SPOUSE_EMPLOYER', '',
                        ['class' => 'form-control',
                        ]) 
                    !!}
                </div>

                <div class="col-lg-12"></div>

                <div class="col-lg-4">
                    <h4>Address of Spouse's Employer</h4>
                </div>

                <div class="col-lg-8">
                    {!! Form::text('SPOUSE_EMPLOYER_ADDRESS', '',
                        ['class' => 'form-control',
                        ]) 
                    !!}
                </div>

                <div class="col-lg-12"></div>

                <div class="col-lg-4">
                    <h4>Date of Spouse's Hiring</h4>
                </div>

                <div class="col-lg-8">
                    {!! Form::text('SPOUSE_DATE_HIRED', '',
                        ['class' => 'form-control date',
                        ]) 
                    !!}
                </div>

                @if($errors->has('SPOUSE_DATE_HIRED'))
                    <div class="col-lg-8 col-lg-offset-4">
                        <p class="red">Please input a valid date.</p>
                    </div>
                @endif

                <div class="col-lg-12"></div>

                <div class="col-lg-4">
                    <h4>Phone Number of Spouse's Employer</h4>
                </div>

                <div class="col-lg-8">
                    {!! Form::text('SPOUSE_EMPLOYER_NUMBER', '',
                        ['class' => 'form-control phone',
                        ]) 
                    !!}
                </div>

                @if($errors->has('SPOUSE_EMPLOYER_NUMBER'))
                    <div class="col-lg-8 col-lg-offset-4">
                        <p class="red">Please input a valid phone number.</p>
                    </div>
                @endif

                <div class="col-lg-12"><center><h3>I hereby designate the person(s) stated below to be the beneficiary(ies) of any benefits to which I may be entitled under the Building Trades Welfare Benefit Funds following my death.</h3></center></div>

                <div class="col-lg-12" style="min-width:700px">
                    <table class="table table-bordered">
                        <thead>
                            <td class="col-lg-1">#</td>
                            <td class="col-lg-4">Full Name</td>
                            <td class="col-lg-2">SSN</td>
                            <td class="col-lg-2">Date of Birth</td>
                            <td class="col-lg-2">Relationship</td>
                            <td class="col-lg-1">PCT.</td>
                        </thead>
                        <tbody>
                            @for($i = 1; $i <= 3; $i++)
                                <tr>
                                    <td> {{$i}}</td>
                                    <td>
                                        {!! Form::text('BENEFICIARY' . $i, '',
                                            ['class' => 'form-control',
                                            ]) 
                                        !!}
                                    </td>
                                    <td>
                                        {!! Form::text('BENE_SSN' . $i, '',
                                            ['class' => 'form-control ssn',
                                            ]) 
                                        !!}
                                        @if($errors->has('BENE_SSN' . $i))
                                            <p class="red">Please input a valid social security number.</p>
                                        @endif
                                    </td>
                                    <td>
                                        {!! Form::text('BENE_DOB' . $i, '',
                                            ['class' => 'form-control date',
                                            ]) 
                                        !!}
                                        @if($errors->has('BENE_DOB' . $i))
                                            <p class="red">Please input a valid date.</p>
                                        @endif
                                    </td>
                                    <td>
                                        {!! Form::text('BENE_RELATIONSHIP' . $i, '',
                                            ['class' => 'form-control',
                                            ]) 
                                        !!}
                                    </td>
                                    <td>
                                        {!! Form::number('PCT' . $i, '',
                                            ['class' => 'form-control',
                                            ]) 
                                        !!}
                                    </td>
                                </tr>
                            @endfor
                        </tbody>
                    </table>
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