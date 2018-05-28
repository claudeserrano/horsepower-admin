@extends('layout')

@section('title')
    Horsepower - {{$lang->bif}}
@stop

@section('content')

        <div class="container content">

            <div class="col-lg-12"> 
                <center>
                    <h1>
                        {{$lang->bif}}
                    </h1>
                    <a href="form/lang/{{$lang->alt}}" class="btn btn-primary"><h6>{{$lang->alt_text}}</h6></a>
                </center>
            </div>

            <form class="form-horizontal" role="form" method="POST" action="{{ route('submitForm', ['form' => 'bf']) }}">
            
            {{ csrf_field() }}

            <input type="hidden" name="lang" value="1"/>

            <div class="col-lg-12">

                <div class="col-lg-12"><h3>{{$lang->member_full_name}}</h3></div>

                <div class="col-lg-2">
                    <h4>{{$lang->last_name}}</h4>
                </div>
                <div class="col-lg-2">
                    {!! Form::text('LAST_NAME', $data->LName,
                        ['class' => 'form-control',
                        ])
                    !!}
                    @if($errors->has('LAST_NAME'))
                        <p class="red">Please input your last name.</p>
                    @endif
                </div>
                
                <div class="col-lg-2">
                    <h4>{{$lang->first_name}}</h4>
                </div>
                <div class="col-lg-3">
                    {!! Form::text('FIRST_NAME', $data->FName,
                        ['class' => 'form-control',
                        ])
                    !!}
                    @if($errors->has('FIRST_NAME'))
                        <p class="red">Please input your first name.</p>
                    @endif
                </div>

                <div class="col-lg-1">
                    <h4>{{$lang->initials}}</h4>
                </div>
                <div class="col-lg-2">
                    {!! Form::text('INITIALS', $data->MI,
                        ['class' => 'form-control',
                        ]) 
                    !!}
                </div>

                <div class="col-lg-12"><br></div>

                <div class="col-lg-4">
                    <h4>{{$lang->ssn}}</h4>
                </div>

                <div class="col-lg-8">
                    {!! Form::text('SSN', $data->SSN1 . '-' . $data->SSN2 . '-' . $data->SSN3,
                        ['class' => 'form-control ssn',
                        ]) 
                    !!}
                    @if($errors->has('SSN'))
                        <p class="red">{{$errors->first('SSN')}}</p>
                    @endif
                </div>

                <div class="col-lg-12"><br></div>

                <div class="col-lg-4">
                    <h4>{{$lang->cell_no}}</h4>
                </div>

                <div class="col-lg-8">
                    {!! Form::text('NUMBER', '(' . $data->AreaCodePhone . ') ' . $data->CellNo1 . '-' . $data->CellNo2,
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
                    <h4>{{$lang->dob}}</h4>
                </div>

                <div class="col-lg-8">
                    {!! Form::text('DOB', $data->DOBMonth . '-' . $data->DOBDay . '-' . $data->DOBYear,
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
                    <h4>{{$lang->email}}</h4>
                </div>

                <div class="col-lg-8">
                    {!! Form::email('EMAIL', $data->Email,
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
                    <h4>{{$lang->sex}}</h4>
                </div>
                
                <div class="col-lg-3">
                    <div class="form-check">
                      <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="SEX" value="M" @if($data->Sex == 'Male') checked @endif>
                        {{$lang->male}}
                      </label>
                    </div>
                    <div class="form-check">
                      <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="SEX" value="F" @if($data->Sex == 'Female') checked @endif>
                        {{$lang->female}}
                      </label>
                    </div>
                </div>

                <div class="col-lg-3">
                    <h4>{{$lang->marital_status}}</h4>
                </div>
                
                <div class="col-lg-3">
                    <div class="form-check">
                      <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="Status" value="Married" checked>
                        {{$lang->married}}
                      </label>
                    </div>
                    <div class="form-check">
                      <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="Status" value="Single">
                        {{$lang->single}}
                      </label>
                    </div>
                    <div class="form-check">
                      <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="Status" value="Divorced">
                        {{$lang->divorced}}
                      </label>
                    </div>
                    <div class="form-check">
                      <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="Status" value="Widow">
                        {{$lang->widower}}
                      </label>
                    </div>
                </div>

                <div class="col-lg-12"><h3>{{$lang->member_add}}</h3></div>

                <div class="col-lg-2">
                    <h4>{{$lang->street}}</h4>
                </div>

                <div class="col-lg-3">
                    {!! Form::text('STREET_ADDRESS', isset($data->Number) ? $data->Number . ' ' . $data->Street : $data->Street,
                        ['class' => 'form-control',
                        ]) 
                    !!}
                    @if($errors->has('STREET_ADDRESS'))
                        <p class="red">Please input a street address.</p>
                    @endif
                </div>

                <div class="col-lg-2">
                    <h4>{{$lang->number}}</h4>
                </div>

                <div class="col-lg-1">
                    {!! Form::text('APT', $data->aptNo,
                        ['class' => 'form-control',
                        ]) 
                    !!}
                </div>

                <div class="col-lg-12"></div>
                
                <div class="col-lg-2">
                    <h4>{{$lang->city}}</h4>
                </div>
                <div class="col-lg-3">
                    {!! Form::text('CITY', $data->City,
                        ['class' => 'form-control',
                        ]) 
                    !!}
                    @if($errors->has('CITY'))
                        <p class="red">Please input the city you reside in.</p>
                    @endif
                </div>
                
                <div class="col-lg-2">
                    <h4>{{$lang->state}}</h4>
                </div>
                <div class="col-lg-1">
                    {!! Form::text('STATE', $data->State,
                        ['class' => 'form-control',
                        ]) 
                    !!}
                    @if($errors->has('STATE'))
                        <p class="red">Please input the state you reside in.</p>
                    @endif
                </div>

                <div class="col-lg-1">
                    <h4>{{$lang->zip}}</h4>
                </div>
                <div class="col-lg-3">
                    {!! Form::number('ZIP', $data->Zip,
                        ['class' => 'form-control',
                        ]) 
                    !!}
                    @if($errors->has('ZIP'))
                        <p class="red">Please input the zip where you reside in.</p>
                    @endif
                </div>

                <div class="col-lg-12"><br></div>
                
                <div class="col-lg-4">
                    <h4>{{$lang->shop_name}}</h4>
                </div>

                <div class="col-lg-8">
                    {!! Form::text('SHOP_NAME', 'Horsepower Electric',
                        ['class' => 'form-control', 'readonly' => true,
                        ]) 
                    !!}
                </div>

                <div class="col-lg-12"><br></div>

                <div class="col-lg-4">
                    <h4>{{$lang->job_class}}</h4>
                </div>

                {{-- div class="col-lg-8">
                    {!! Form::text('JobClass', '',
                        ['class' => 'form-control',
                        ]) 
                    !!}
                </div>

                @if($errors->has('JobClass'))
                    <div class="col-lg-8 col-lg-offset-4">
                        <p class="red">Please input your job classification.</p>
                    </div>
                @endif --}}

                <div class="col-lg-12"><br></div>

                <div class="col-lg-4">
                    <h4>{{$lang->date_hired}}</h4>
                </div>

                <div class="col-lg-8">
                    {!! Form::text('HireDate', '',
                        ['class' => 'form-control date',
                        ]) 
                    !!}
                </div>

                @if($errors->has('HireDate'))
                    <div class="col-lg-8 col-lg-offset-4">
                        <p class="red">Please input a valid date.</p>
                    </div>
                @endif

                <div class="col-lg-12"><center><h3>{{$lang->complete_the_following}}</h3><p class="red" id="fam_warning" hidden>Please check your dependents information. Please fill all information for a dependent.</p></center></div>

                <div class="col-lg-12" style="min-width:700px">
                    <table class="table table-bordered">
                        <thead>
                            <td class="col-lg-1">#</td>
                            <td class="col-lg-4">{{$lang->full_name}}</td>
                            <td class="col-lg-2">{{$lang->dob}}</td>
                            <td class="col-lg-1">{{$lang->sex}}</td>
                            <td class="col-lg-2">{{$lang->ssn}}</td>
                            <td class="col-lg-2">{{$lang->relationship}}</td>
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

                <div class="col-lg-12"><center><h3>{{$lang->if_married}}</h3></center></div>

                <div class="col-lg-4">
                    <h4>{{$lang->date_married}}</h4>
                </div>

                <div class="col-lg-8">
                    {!! Form::text('DateMarried', '',
                        ['class' => 'form-control date',
                        ]) 
                    !!}
                </div>

                @if($errors->has('DateMarried'))
                    <div class="col-lg-8 col-lg-offset-4">
                        <p class="red">Please input a valid date.</p>
                    </div>
                @endif

                <div class="col-lg-12"><br></div>

                <div class="col-lg-4">
                    <h4>{{$lang->place_married}}</h4>
                </div>

                <div class="col-lg-8">
                    {!! Form::text('PlaceMarried', '',
                        ['class' => 'form-control',
                        ]) 
                    !!}
                </div>

                <div class="col-lg-12"><center><h3>{{$lang->if_divorced}}</h3></center></div>

                <div class="col-lg-4">
                    <h4>{{$lang->date_divorced}}</h4>
                </div>

                <div class="col-lg-8">
                    {!! Form::text('DateDivorced', '',
                        ['class' => 'form-control date',
                        ]) 
                    !!}
                </div>

                @if($errors->has('DateDivorced'))
                    <div class="col-lg-8 col-lg-offset-4">
                        <p class="red">Please input a valid date.</p>
                    </div>
                @endif

                <div class="col-lg-12"><br></div>

                <div class="col-lg-4">
                    <h4>{{$lang->coverage_dependents}}</h4>
                </div>
                
                <div class="col-lg-8">
                    <div class="form-check">
                      <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="CourtOrder" value="Y">
                        {{$lang->yes}}
                      </label>
                    </div>
                    <div class="form-check">
                      <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="CourtOrder" value="N" checked>
                        {{$lang->no}}
                      </label>
                    </div>
                </div>

                <div class="col-lg-12"><center><h3>{{$lang->spouse_employed}}</h3></center></div>

                <div class="col-lg-4">
                    <h4>{{$lang->name_spouse_employer}}</h4>
                </div>

                <div class="col-lg-8">
                    {!! Form::text('SpouseEmployer', '',
                        ['class' => 'form-control',
                        ]) 
                    !!}
                </div>

                <div class="col-lg-12"></div>

                <div class="col-lg-4">
                    <h4>{{$lang->address_spouse_employer}}r</h4>
                </div>

                <div class="col-lg-8">
                    {!! Form::text('SpouseEmployerAddress', '',
                        ['class' => 'form-control',
                        ]) 
                    !!}
                </div>

                <div class="col-lg-12"></div>

                <div class="col-lg-4">
                    <h4>{{$lang->date_spouse_hired}}</h4>
                </div>

                <div class="col-lg-8">
                    {!! Form::text('SpouseDateHired', '',
                        ['class' => 'form-control date',
                        ]) 
                    !!}
                </div>

                @if($errors->has('SpouseDateHired'))
                    <div class="col-lg-8 col-lg-offset-4">
                        <p class="red">Please input a valid date.</p>
                    </div>
                @endif

                <div class="col-lg-12"></div>

                <div class="col-lg-4">
                    <h4>{{$lang->phone_spouse_employer}}</h4>
                </div>

                <div class="col-lg-8">
                    {!! Form::text('SpouseEmployerNumber', '',
                        ['class' => 'form-control phone',
                        ]) 
                    !!}
                </div>

                @if($errors->has('SpouseEmployerNumber'))
                    <div class="col-lg-8 col-lg-offset-4">
                        <p class="red">Please input a valid phone number.</p>
                    </div>
                @endif

                <div class="col-lg-12"><center><h3>{{$lang->designation}}</h3>
                <p class="red" id="bene_warning" hidden>Please check your beneficiary information. At least one beneficiary is needed.</p></center></div>


                <div class="col-lg-12" style="min-width:700px">
                    <table class="table table-bordered">
                        <thead>
                            <td class="col-lg-1">#</td>
                            <td class="col-lg-4">{{$lang->full_name}}</td>
                            <td class="col-lg-2">{{$lang->ssn}}</td>
                            <td class="col-lg-2">{{$lang->dob}}</td>
                            <td class="col-lg-2">{{$lang->relationship}}</td>
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

        function checkBeneficiaries(){
            pass = true;
            count = 0;

            for(var i = 1; i <= 3; i++){
                var bene = "input[name='BENEFICIARY" + i +"']";
                var bene_ssn = "input[name='BENE_SSN" + i +"']";
                var bene_dob = "input[name='BENE_DOB" + i +"']";
                var bene_rel = "input[name='BENE_RELATIONSHIP" + i +"']";
                var bene_pct = "input[name='PCT" + i +"']";
                if($(bene).val() || $(bene_ssn).val() || $(bene_dob).val() || $(bene_rel).val() || $(bene_pct).val()){
                    if(!$(bene).val() || !$(bene_ssn).val() || !$(bene_dob).val() || !$(bene_rel).val() || !$(bene_pct).val()){
                        pass = false;
                        alert('Please fill up everything under beneficiary # ' + i + '.');
                    }
                    else
                        count++;
                }
            }

            if(count == 0){
                $('#bene_warning').show();
                pass = false;
            }
            else
                $('#bene_warning').hide();

            return pass;
        }

        function checkDependents(){
            pass = true;
            count = 0;

            for(var i = 1; i <= 8; i++){
                var fam = "input[name='FAMILY" + i +"']";
                var fam_ssn = "input[name='FAMILY_SSN" + i +"']";
                var fam_dob = "input[name='FAMILY_DOB" + i +"']";
                var fam_rel = "input[name='FAMILY_RELATIONSHIP" + i +"']";
                var fam_sex = "input[name='SEX" + i +"']";
                if($(fam).val() || $(fam_ssn).val() || $(fam_dob).val() || $(fam_rel).val() || $(fam_sex).val()){
                    if(!$(fam).val() || !$(fam_ssn).val() || !$(fam_dob).val() || !$(fam_rel).val() || !$(fam_sex).val()){
                        pass = false;
                        alert('Please fill up everything under dependent # ' + i + '.');
                        $('#fam_warning').show();
                    }
                    else
                        count++;
                }
            }

            return pass;
        }

        $(document).ready(function(){
            $(document).on("click", "button[type='submit']", function(event){
                pass_bene = checkBeneficiaries();
                pass_dep = checkDependents();
                pass = pass_bene && pass_dep;

                if(!pass){
                    // alert('Please check beneficiaries information!');
                    event.preventDefault();
                }

                if(signaturePad.isEmpty()){
                    alert('Please input your signature.');
                    event.preventDefault();
                }
                else{
                    signature();
                }
            })
        });
    </script>
    
@endsection