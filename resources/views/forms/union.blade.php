@extends('layout')

@section('title')
	Horsepower - Local 363 Form
@endsection

@section('content')
	<div class="container content">
			<div class="col-lg-12" style="padding-bottom:20px">
			    <center>
                    <h1> Local 363 Enrollment Form </h1>
                    <a href="form/lang/{{$lang->alt}}" class="btn btn-primary"><h6>{{$lang->alt_text}}</h6></a>
                </center>
			</div>

    	    <form class="form-horizontal" role="form" method="POST" action="{{ route('submitForm', ['form' => 'union']) }}">

            {{ csrf_field() }}

    	    	<div class="col-lg-12 panel panel-default">
    	    		<div class="panel-heading">
    	    			<center><h4>Employee Information</h4></center>
    	    		</div>
    	    		<div class="panel-body">

    	    			<div class="col-lg-3">
    	    			    <h4>{{$lang->first_name}}</h4>
    	    			</div>
    	    			<div class="col-lg-3">
    	    			    {!! Form::text('first_name', $data->FName,
    	    			        ['class' => 'form-control',
    	    			        ])
    	    			    !!}

    	    			    @if($errors->has('first_name'))
    	    			        <p class="red">Please input your first name.</p>
    	    			    @endif
    	    			</div>

    	    			<div class="col-lg-2">
    	    			    <h4>{{$lang->last_name}}</h4>
    	    			</div>
    	    			<div class="col-lg-2">
    	    			    {!! Form::text('last_name', $data->LName,
    	    			        ['class' => 'form-control',
    	    			        ]) 
    	    			    !!}

    	    			    @if($errors->has('last_name'))
    	    			        <p class="red">Please input your last name.</p>
    	    			    @endif
    	    			</div>


                        <div class="col-lg-1">
                            <h4>{{$lang->initials}}</h4>
                        </div>
                        <div class="col-lg-1">
                            {!! Form::text('initials', $data->MI,
                                ['class' => 'form-control',
                                ]) 
                            !!}
                        </div>

    	    			<div class="col-lg-12"></div>

    	    			<div class="col-lg-3">
    	    			    <h4>{{$lang->sex}}</h4>
    	    			</div>
    	    			
    	    			<div class="col-lg-3">
						  	<select class="form-control" name="sex">
							    <option value="M" @if($data->Sex == 'Male') selected @endif>{{$lang->male}}</option>
							    <option value="F" @if($data->Sex == 'Female') selected @endif>{{$lang->female}}</option>
						  	</select>
    	    			</div>

    	    			<div class="col-lg-3">
    	    			    <h4>{{$lang->dob}}</h4>
    	    			</div>

    	    			<div class="col-lg-3">
    	    			    {!! Form::text('dob', $data->DOBMonth . '-' . $data->DOBDay . '-' . $data->DOBYear,
    	    			        ['class' => 'form-control date',
    	    			        ]) 
    	    			    !!}

    	    			    @if($errors->has('dob'))
    	    			        <p class="red">Please enter a valid date.</p>
    	    			    @endif
    	    			</div>


    	    			<div class="col-lg-12"></div>

    	    			<div class="col-lg-3">
    	    			    <h4>{{$lang->marital_status}}</h4>
    	    			</div>
    	    			
    	    			<div class="col-lg-3">
						  	<select class="form-control" name="marital_status">
							    <option>{{$lang->married}}</option>
							    <option>{{$lang->divorced}}</option>
							    <option>{{$lang->single}}</option>
							    <option>{{$lang->widower}}</option>
							    <option>{{$lang->separated}}</option>
						  	</select>
    	    			</div>

    	    			<div class="col-lg-3">
    	    			    <h4>{{$lang->ssn}}</h4>
    	    			</div>
    	    			<div class="col-lg-3">
    	    			    {!! Form::text('ssn', $data->SSN1 . '-' . $data->SSN2 . '-' . $data->SSN3,
    	    			        ['class' => 'form-control ssn',
    	    			        ]) 
    	    			    !!}

    	    			    @if($errors->has('ssn'))
    	    			        <p class="red">Please input a valid social security number.</p>
    	    			    @endif
    	    			</div>

    	    			<div class="col-lg-12"></div>

    	    			<div class="col-lg-3">
    	    			    <h4>{{$lang->street}}</h4>
    	    			</div>
    	    			<div class="col-lg-3">
    	    			    {!! Form::text('street_address', isset($data->Number) ? $data->Number . ' '  . $data->Street : $data->Street,
    	    			        ['class' => 'form-control',
    	    			        ]) 
    	    			    !!}
    	    			    
    	    			    @if($errors->has('street_address'))
    	    			        <p class="red">Please input your street address.</p>
    	    			    @endif
    	    			</div>

                        <div class="col-lg-3">
                            <h4>{{$lang->number}}</h4>
                        </div>
                        <div class="col-lg-3">
                            {!! Form::text('apartment_no', $data->aptNo,
                                ['class' => 'form-control',
                                ]) 
                            !!}
                        </div>

    	    			<div class="col-lg-12"></div>

                        <div class="col-lg-3">
                            <h4>{{$lang->city}}</h4>
                        </div>
                        <div class="col-lg-3">
                            {!! Form::text('city', $data->City,
                                ['class' => 'form-control',
                                ]) 
                            !!}

                            @if($errors->has('city'))
                                <p class="red">Please input the city you live in.</p>
                            @endif
                        </div>

    	    			<div class="col-lg-1">
    	    			    <h4>{{$lang->state}}</h4>
    	    			</div>
    	    			<div class="col-lg-2">
    	    			    {!! Form::text('state', $data->State,
    	    			        ['class' => 'form-control',
    	    			        ]) 
    	    			    !!}
    	    			    
    	    			    @if($errors->has('state'))
    	    			        <p class="red">Please input the state you live in.</p>
    	    			    @endif
    	    			</div>

    	    			<div class="col-lg-1">
    	    			    <h4>{{$lang->zip}}</h4>
    	    			</div>
    	    			<div class="col-lg-2">
    	    			    {!! Form::number('home_zip', $data->Zip,
    	    			        ['class' => 'form-control',
    	    			        ]) 
    	    			    !!}

    	    			    @if($errors->has('home_zip'))
    	    			        <p class="red">Please input the zip code of the area you live in.</p>
    	    			    @endif
    	    			</div>

    	    			<div class="col-lg-12"></div>

    	    			<div class="col-lg-3">
    	    			    <h4>{{$lang->tel_no}}</h4>
    	    			</div>
    	    			<div class="col-lg-3">
    	    			    {!! Form::text('HomePhone', '(' . $data->AreaCode . ') ' . $data->TelNo1 . '-' . $data->TelNo2,
    	    			        ['class' => 'form-control phone',
    	    			        ]) 
    	    			    !!}
    	    			    
    	    			    @if($errors->has('HomePhone'))
    	    			        <p class="red">Please input your phone number.</p>
    	    			    @endif
    	    			</div>

    	    			<div class="col-lg-3">
    	    			    <h4>{{$lang->email}}</h4>
    	    			</div>
    	    			<div class="col-lg-3">
    	    			    {!! Form::email('Email', $data->Email,
    	    			        ['class' => 'form-control email',
    	    			        ]) 
    	    			    !!}
    	    			    
    	    			    @if($errors->has('email'))
    	    			        <p class="red">Please input your email address.</p>
    	    			    @endif
    	    			</div>

                        <div class="col-lg-12"></div>

                        <div class="col-lg-3">
                            <h4>Work Phone</h4>
                        </div>
                        <div class="col-lg-3">
                            {!! Form::text('WorkPhone', '',
                                ['class' => 'form-control phone',
                                ]) 
                            !!}
                        </div>

    	    			<div class="col-lg-3">
    	    			    <h4>{{$lang->company_name}}</h4>
    	    			</div>
    	    			<div class="col-lg-3">
    	    			    {!! Form::text('company_name', 'Horsepower Electric',
    	    			        ['class' => 'form-control',
    	    			         'readonly' => true
    	    			        ]) 
    	    			    !!}
    	    			</div>

                        <div class="col-lg-12"></div>

                        <div class="col-lg-3">
                            <h4>{{$lang->company_address}}</h4>
                        </div>
                        <div class="col-lg-6">
                            {!! Form::text('company_address', '4101 1st Avenue, Brooklyn, NY',
                                ['class' => 'form-control',
                                 'readonly' => true
                                ]) 
                            !!}
                        </div>

                        <div class="col-lg-1">
                            <h4>{{$lang->zip}}</h4>
                        </div>
                        <div class="col-lg-2">
                            {!! Form::text('work_zip', '11232',
                                ['class' => 'form-control',
                                 'readonly' => true
                                ]) 
                            !!}
                        </div>

                        <div class="col-lg-12"></div>

                        {{-- <div class="col-lg-3">
                            <h4>Job Title</h4>
                        </div>
                        <div class="col-lg-3">
                            {!! Form::email('job_title', '',
                                ['class' => 'form-control',
                                ]) 
                            !!}
                            
                            @if($errors->has('job_title'))
                                <p class="red">Please input your job title.</p>
                            @endif
                        </div> --}}

                        <div class="col-lg-3">
                            <h4>{{$lang->date_hired}}</h4>
                        </div>
                        <div class="col-lg-3">
                            {!! Form::text('DateHired', old('PrimaryAddress'),
                                ['class' => 'form-control date',
                                ]) 
                            !!}
                            
                            @if($errors->has('DateHired'))
                                <p class="red">Please input a valid date.</p>
                            @endif
                        </div>

                        <div class="col-lg-12"></div>

                        {{-- <div class="col-lg-3">
                            <h4>Previous Employer</h4>
                        </div>
                        <div class="col-lg-3">
                            {!! Form::text('date_of_hire', ' ',
                                ['class' => 'form-control date',
                                ]) 
                            !!}
                            
                            @if($errors->has('date_of_hire'))
                                <p class="red">Please input you previous employer. If no previous employer, put n/a.</p>
                            @endif
                        </div> --}}

                        <div class="col-lg-12"></div>

                        {{-- <div class="col-lg-3">
                            <h4>Union Affiliation</h4>
                        </div>
                        <div class="col-lg-3">
                            {!! Form::email('union_affiliation', '',
                                ['class' => 'form-control',
                                ]) 
                            !!}
                            
                            @if($errors->has('union_affiliation'))
                                <p class="red">Please input union affiliation.</p>
                            @endif
                        </div>

                        <div class="col-lg-3">
                            <h4>Classification</h4>
                        </div>
                        <div class="col-lg-3">
                            <select class="form-control" name="classification">
                                <option>1st Year Apprentice</option>
                                <option>2nd Year Apprentice</option>
                                <option>3rd Year Apprentice</option>
                                <option>4th Year Apprentice</option>
                                <option>5th Year Apprentice</option>
                                <option>M1 Mechanic</option>
                                <option>M2 Mechanic</option>
                                <option>Mechanic</option>
                                <option>Journeyman</option>
                            </select>
                        </div> --}}

    	    		</div>
    	    	</div>
            <center>


                <div class="col-lg-12 panel panel-default">
                    <div class="panel-heading">
                        <h4>UWF Security Fund Beneficiaries (If Applicable)</h4>
                    </div>
                    <div class="panel-body">
                        <div class="col-lg-12" style="padding-bottom: 15px">
                            <p> {{--<b>Share Partition (%)</b> lets you specify a specify percentage for each beneficiary. If you don't specify a share percentage, it will split evenly among all beneficiaries. <br><br> --}}
                                <span class="glyphicon glyphicon-asterisk"></span> 
                                {{-- If share percentage is specified for any primary beneficiaries, then the total share percentage must add up to 100% for all primary beneficiaries. 
                                <br>If share percentage is specified for any secondary beneficiaries, then the total share percentage must add up to 100% for all secondary beneficiaries.<br> --}}
                                {{$lang->bene_warn}}
                            </p>
                            {{-- <a class="btn btn-default" id="add_beneficiary"><span class="glyphicon glyphicon-plus"></span> Add Beneficiary </a> --}}
                        </div>

                        <div class="col-lg-12" id="beneficiaries">
                            <div class="panel panel-default">
                                <div class="panel-body">

                                    @if($errors->has('PrimaryName') || $errors->has('PrimaryRel') || $errors->has('PrimaryAddress'))

                                    <p class="red">There must be at least one beneificary.</p>
                                    @endif


                                    <p id="primary" class="red" hidden>Please check your beneficiary information. Please fill out all information about your beneficiary.</p>

                                    <div class="col-lg-12" style="padding-bottom:20px">
                                        <h4>
                                            <span class="pull-left">
                                            <span class="glyphicon glyphicon-user"></span>{{$lang->beneficiary}}</span> 
                                        </h4>
                                    </div>
                                    <div class="col-lg-12"> 
                                        <div class="col-lg-2"> 
                                            <h4>{{$lang->type}}</h4> 
                                        </div>
                                        <div class="col-lg-2"> 
                                            {{-- <select class="form-control type" name="primary_type">
                                                <option value="Primary">Primary</option>
                                            </select>  --}}
                                            <input class="form-control" name="PrimaryType" type="text" value="Primary" disabled>
                                        </div>
                                        <div class="col-lg-2"> 
                                            <h4>{{$lang->full_name}}</h4> 
                                        </div>
                                        <div class="col-lg-6"> 
                                            <input class="form-control" name="PrimaryName" type="text" value='@if(sizeof($data['bene']) > 0 && $data['bene'][0] != null){{$data['bene'][0]['full_name']}}@endif'> 
                                        </div>
                                        <div class="col-lg-12"></div>
                                        <div class="col-lg-2"> 
                                            <h4>{{$lang->relationship}}</h4> 
                                        </div>
                                        <div class="col-lg-2"> 
                                            <input class="form-control" name="PrimaryRel" type="text" value='@if(sizeof($data['bene']) > 0 &&$data['bene'][0] != null){{$data['bene'][0]['relationship']}}@endif'> 
                                        </div>
                                        <div class="col-lg-2"> 
                                            <h4>{{$lang->address}}</h4> 
                                        </div>
                                        <div class="col-lg-6"> 
                                            <input class="form-control" name="PrimaryAddress" type="text" value="{{old('PrimaryAddress')}}"> 
                                        </div>
                                        {{-- <div class="col-lg-2"> 
                                            <h4>Share (%)</h4> 
                                        </div>
                                        <div class="col-lg-4"> 
                                            <input class="form-control" name="primary_share" type="number" value=""> 
                                        </div> --}}
                                        <div class="col-lg-12"></div>
                                        {{-- <div class="col-lg-2"> 
                                            <h4>Street Address</h4> 
                                        </div>
                                        <div class="col-lg-4"> 
                                            <input class="form-control" name="primary_address" type="" value=""> 
                                        </div>
                                        <div class="col-lg-2"> 
                                            <h4>City</h4> 
                                        </div>
                                        <div class="col-lg-4"> 
                                            <input class="form-control" name="primary_city" type="" value=""> 
                                        </div>
                                        <div class="col-lg-12"></div>
                                        <div class="col-lg-2"> <h4>State</h4> </div>
                                        <div class="col-lg-4"> 
                                            <input class="form-control" name="primary_state" type="" value=""> 
                                        </div>
                                        <div class="col-lg-2"> <h4>Zip</h4> </div>
                                        <div class="col-lg-4"> 
                                            <input class="form-control" name="primary_zip" type="number" value=""> 
                                        </div> --}}
                                    </div>
                                </div>
                            </div>

                            <div class="panel panel-default">
                                <div class="panel-body">

                                    <p class="red" id="secondary" hidden>Please check your beneficiary information.</p>

                                    <div class="col-lg-12" style="padding-bottom:20px">
                                        <h4>
                                            <span class="pull-left">
                                            <span class="glyphicon glyphicon-user"></span> {{$lang->beneficiary}}</span> 
                                        </h4>
                                    </div>
                                    <div class="col-lg-12"> 
                                        <div class="col-lg-2"> 
                                            <h4>{{$lang->type}}</h4> 
                                        </div>
                                        <div class="col-lg-2"> 
                                            <input class="form-control" name="SecondaryType" type="text" value="Secondary" disabled>
                                        </div>
                                        <div class="col-lg-2"> 
                                            <h4>{{$lang->full_name}}</h4> 
                                        </div>
                                        <div class="col-lg-6"> 
                                            <input class="form-control" name="SecondaryName" type="text" value='@if(sizeof($data['bene']) > 1 &&$data['bene'][1] != null){{$data['bene'][1]['full_name']}}@endif'> 
                                        </div>
                                        <div class="col-lg-12"></div>
                                        <div class="col-lg-2"> 
                                            <h4>{{$lang->relationship}}</h4> 
                                        </div>
                                        <div class="col-lg-2"> 
                                            <input class="form-control" name="SecondaryRel" type="text" value='@if(sizeof($data['bene']) > 1 &&$data['bene'][1] != null){{$data['bene'][1]['relationship']}}@endif'> 
                                        </div>
                                        <div class="col-lg-2"> 
                                            <h4>{{$lang->address}}</h4> 
                                        </div>
                                        <div class="col-lg-6"> 
                                            <input class="form-control" name="SecondaryAddress" type="text" value=""> 
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="panel panel-default">
                                <div class="panel-body">

                                    <p class="red" id="tertiary" hidden>Please check your beneficiary information.</p>

                                    <div class="col-lg-12" style="padding-bottom:20px">
                                        <h4>
                                            <span class="pull-left">
                                            <span class="glyphicon glyphicon-user"></span> {{$lang->beneficiary}}</span> 
                                        </h4>
                                    </div>
                                    <div class="col-lg-12"> 
                                        <div class="col-lg-2"> 
                                            <h4>{{$lang->type}}</h4> 
                                        </div>
                                        <div class="col-lg-2"> 
                                            <input class="form-control" name="TertiaryType" type="text" value="Secondary" disabled>
                                        </div>
                                        <div class="col-lg-2"> 
                                            <h4>{{$lang->full_name}}</h4> 
                                        </div>
                                        <div class="col-lg-6"> 
                                            <input class="form-control" name="TertiaryName" type="text" value='@if(sizeof($data['bene']) > 2 &&$data['bene'][2] != null){{$data['bene'][2]['full_name']}}@endif'> 
                                        </div>
                                        <div class="col-lg-12"></div>
                                        <div class="col-lg-2"> 
                                            <h4>{{$lang->relationship}}</h4> 
                                        </div>
                                        <div class="col-lg-2"> 
                                            <input class="form-control" name="TertiaryRel" type="text" value='@if(sizeof($data['bene']) > 2 &&$data['bene'][2] != null){{$data['bene'][2]['relationship']}}@endif'> 
                                        </div>
                                        <div class="col-lg-2"> 
                                            <h4>{{$lang->address}}</h4> 
                                        </div>
                                        <div class="col-lg-6"> 
                                            <input class="form-control" name="TertiaryAddress" type="text" value=""> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12 panel panel-default">
                    <div class="panel-heading">
                        <h4>{{$lang->authorization}}</h4>
                    </div>
                    <div class="panel-body">

                        <div class="col-lg-12">
                            <h3 class="red">Application for Membership</h3>
                            <h5>I apply for membership in LOCAL 363 and designate this Union to represent me for collective bargaining with my employer.</h5>

                            <div class="col-lg-12"><hr></div>

                            <h3 class="red">Checkoff Authorization</h3>
                            <h5>I direct my employer to deduct from my wages and to pay to LOCAL 363 dues and initiation fees in said Union as may be established by the Union and become due to it from me during the effective period of this authorization. This authorization may be revoked by me by written notice signed by me as of any anniversary date hereof or termination date of any collective bargaining agreement covering my employment, whichever occurs sooner. This authorization shall automatically renew unless written revocation is submitted.</h5>

                            <br>

                            <div id="signature-pad" class="signature-pad">
                                <div class="signature-pad--body">
                                    <canvas id="canvas"></canvas>
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

                            <input type="hidden" name="uri" id="uri"></input>
                        </div>
                    </div>
                </div>

                {{-- <div class="col-lg-12 panel panel-default">
                    <div class="panel-heading">
                        <h4>Notes (Maximum 2000 Characters)</h4>
                    </div>
                    <div class="panel-body">
                        <div class="col-lg-12">
                            <textarea class="form-control" value="" placeholder="Enter additional notes here" name="notes" rows="5"></textarea>
                        </div>
                    </div>
                </div> --}}

                <div class="col-lg-12 panel panel-default">
                    <div class="panel-heading">
                        <h4>Important Notice Regarding Legal Rights</h4>
                    </div>
                    <div class="panel-body">
                        <div class="col-lg-12">
                            <textarea class="form-control" readonly name="notes" rows="10" disabled>You have a right to be a nonmember of USWU, and nonmembers have the right to: 
    1) object to paying the fraction of Union dues and fees that are not germane to Local USWU’s duties as bargaining agent and to obtain a reduction of fees for such non-germane activities; and 
    2) to obtain from USWU sufficient information to enable you to decide whether to object to USWU’s fair share of dues and fees equivalency calculation; and 
    3) to be told USWU’s internal procedures for objecting. Items 2 and 3 may be obtained by written request addressed to USWU at 138-50 Queens Boulevard, Briarwood, NY 11435. 

    You should be aware, however, that exercising this option of choosing to be a nonmember means you would not have the right to vote on your contract or to participate in the development of contract proposals or local elections. You will also lose the other benefits of membership. USWU hopes you will choose to become an active member and strengthen the Union’s ability to represent you and your co-workers, rather than weakening the Union and making it more difficult to represent you. In our democratic Union, the decision remains yours.
                            </textarea>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="col-lg-4 col-lg-offset-4">
                        <center>
                        <button type="submit" onclick="signature()">Submit</button>
                        </center>
                    </div>
                    <br><br>
                </div>

    	    </form>

		</center>
	</div>
@endsection

@section('scripts')
    <script>
        var canvas = document.getElementById("canvas");

        var signaturePad = new SignaturePad(canvas, {
            minWidth: 1,
            maxWidth: 2,
        });

        function signature(){
            var hidden = document.getElementById('uri');
            hidden.value = signaturePad.toDataURL();
        }

        function checkShare(){
            primary = 100;
            secondary = 100;
            flag = 1;
            $(".type").each(function(){
                value = parseInt($(this).parent().next().next().next().next().next().next().next().find('input').val());
                if(!isNaN(value)){
                    if($(this).val() === "Secondary"){
                        secondary -= value;
                    }
                    else{
                        primary -= value;
                    }
                }
            });

            if(primary > 0 && primary < 100){
                alert('Share partition for primary beneficiaries is not equal to 100.');
                flag = 1;
            }

            if(secondary > 0 && secondary < 100){
                alert('Share partition for secondary beneficiaries is not equal to 100.');
                flag = 1;
            }
            
            if(flag > 0)
                return true;
            else
                return false;
        }

        function checkBeneficiaries(){
            pass = true;
            if($('input[name="PrimaryName"]').val() || $('input[name="PrimaryAddress"]').val() || $('input[name="PrimaryRel"]').val()){
                if(!$('input[name="PrimaryName"]').val() || !$('input[name="PrimaryAddress"]').val() || !$('input[name="PrimaryRel"]').val()){
                    $('#primary').show();
                    pass = false;
                }
                else
                    $('#primary').hide();
            }
            if($('input[name="SecondaryName"]').val() || $('input[name="SecondaryAddress"]').val() || $('input[name="SecondaryRel"]').val()){
                if(!$('input[name="SecondaryName"]').val() || !$('input[name="SecondaryAddress"]').val() || !$('input[name="SecondaryRel"]').val()){
                    $('#secondary').show();
                    pass = false;
                }
                else
                    $('#secondary').hide();
            }
            else
                $('#secondary').hide();

            if($('input[name="TertiaryName"]').val() || $('input[name="TertiaryAddress"]').val() || $('input[name="TertiaryRel"]').val()){
                if(!$('input[name="TertiaryName"]').val() || !$('input[name="TertiaryAddress"]').val() || !$('input[name="TertiaryRel"]').val()){
                    $('#tertiary').show();
                    pass = false;
                }
                else
                    $('#tertiary').hide();
            }
            else
                $('#tertiary').hide();

            return pass;
        }

        $(document).ready(function(){
            var b_index = 1;

            // $(document).on("click", "#add_beneficiary", function(event){
            //     event.preventDefault();
            //     $('#beneficiaries').append('<div id="'+b_index+'" class="panel panel-default"> <div class="panel-body"> <div class="col-lg-12" style="padding-bottom:20px"> <h4><span class="pull-left"><span class="glyphicon glyphicon-user"></span> Beneficiary</span> <button class="btn btn-danger btn-remove-row pull-right" target="'+b_index+'"><span class="glyphicon glyphicon-minus"></span></button> </h4> </div><div class="col-lg-12"> <div class="col-lg-2"> <h4>Type</h4> </div><div class="col-lg-2"> <select class="form-control type" name="type'+b_index+'"><option value="Primary">Primary</option><option value="Secondary">Secondary</option></select> </div><div class="col-lg-2"> <h4>Full Name</h4> </div><div class="col-lg-6"> <input class="form-control" name="b_name'+b_index+'" type="text" value=""> </div><div class="col-lg-12"></div><div class="col-lg-2"> <h4>Relationship</h4> </div><div class="col-lg-4"> <input class="form-control" name="relationship'+b_index+'" type="text" value=""> </div><div class="col-lg-2"> <h4>Share (%)</h4> </div><div class="col-lg-4"> <input class="form-control" name="share'+b_index+'" type="number" value=""> </div><div class="col-lg-12"></div><div class="col-lg-2"> <h4>Street Address</h4> </div><div class="col-lg-4"> <input class="form-control" name="street'+b_index+'" type="" value=""> </div><div class="col-lg-2"> <h4>City</h4> </div><div class="col-lg-4"> <input class="form-control" name="city'+b_index+'" type="" value=""> </div><div class="col-lg-12"></div><div class="col-lg-2"> <h4>State</h4> </div><div class="col-lg-4"> <input class="form-control" name="state'+b_index+'" type="" value=""> </div><div class="col-lg-2"> <h4>Zip</h4> </div><div class="col-lg-4"> <input class="form-control" name="zip'+b_index+'" type="number" value=""> </div></div></div></div>');
            //     b_index++;
            // });

            // $(document).on("click", ".btn-remove-row", function(event){
            //     event.preventDefault();
            //     id = $(this).attr('target');
            //     $('#'+id).remove();
            // });

            $(document).on("click", "button[type='submit']", function(event){
                pass = checkBeneficiaries();

                if(!pass){
                    alert('Please check beneficiaries information!');
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
@stop
