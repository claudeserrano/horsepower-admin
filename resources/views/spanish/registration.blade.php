@extends('layout')

@section('title')Horsepower - Solicitud de Registro de Empleados
@stop

@section('content')

        <div class="container content">

            <div class="col-lg-12"> 
                <center>
                    <h1>
                        Solicitud de Registro de Empleados
                    </h1>

                    <a href="english" class="btn btn-primary"><h6>To English</h6></a>
                </center>
            </div>

            <div class="col-lg-12"><hr></div>

            <form class="form-horizontal" role="form" method="POST" action="{{ route('regpdf', ['lang' => 'Spanish']) }}">
            
            {{ csrf_field() }}

            <div class="col-lg-12">

                <div class="col-lg-4">
                    <h4>Nombre</h4>
                </div>
                <div class="col-lg-8">
                    {!! Form::text('Name', '',
                        ['class' => 'form-control',
                        ]) 
                    !!}
                </div>
                
                @if($errors->has('Name'))
                    <div class="col-lg-8 col-lg-offset-4 red">
                        {{$errors->first('Name')}}
                    </div>
                @endif

                <div class="col-lg-12"></div>

                <div class="col-lg-4">
                    <h4>Numero de Segurida Social</h4>
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

                <div class="col-lg-4">
                    <h4>Direccion (Numero and Calle)</h4>
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
                @endif

                <div class="col-lg-12"></div>

                <div class="col-lg-1">
                    <h4>Ciudad</h4>
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
                    <h4>Estado</h4>
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
                    <h4>Numero de Telefono</h4>
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
                    <h4>Telefono Movil</h4>
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
                    <h4>Solicitado Fecha de Inicio</h4>
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
                    <h4>Correo Electronico</h4>
                </div>
                <div class="col-lg-8">
                    {!! Form::text('Email', '',
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
                    <h4>Solicitado Fecha de Inicio</h4>
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
                    <h4>Empleador</h4>
                </div>

                <div class="col-lg-8">
                    {!! Form::text('Employer', 'Horsepower Electric',
                        ['class' => 'form-control', 'readonly' => true,
                        ]) 
                    !!}
                </div>

                <div class="col-lg-12"><br></div>

                <div class="col-lg-4">
                    <h4>Grupo Etnico</h4>
                </div>
                
                <div class="col-lg-8">
                    <div class="form-check">
                      <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="EthnicGroup" id="exampleRadios1" value="Hispanic" checked>
                        Hispano o Latino
                      </label>
                    </div>
                    <div class="form-check">
                      <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="EthnicGroup" id="exampleRadios2" value="NonHispanic">
                        No Hispano o Latino
                      </label>
                    </div>
                </div>

                <div class="col-lg-12"><br></div>

                <div class="col-lg-4">
                    <h4>Razo</h4>
                </div>
                
                <div class="col-lg-8">
                    <div class="form-check">
                      <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="Race" value="White" checked>
                        Blanco
                      </label>
                    </div>
                    <div class="form-check">
                      <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="Race" value="AfricanAmerican">
                        Afroamericano
                      </label>
                    </div>
                    <div class="form-check">
                      <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="Race" value="Native">
                        Nativo Americano
                      </label>
                    </div>
                    <div class="form-check">
                      <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="Race" value="Asian">
                        Isleno Asiatico o Pacifico
                      </label>
                    </div>
                    <div class="form-check">
                      <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="Race" value="Other">
                        Otro
                      </label>
                    </div>
                </div>

                <div class="col-lg-12"><br></div>

                <div class="col-lg-4">
                    <h4>Sexo</h4>
                </div>
                
                <div class="col-lg-8">
                    <div class="form-check">
                      <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="Sex" value="Male" checked>
                        Masculino
                      </label>
                    </div>
                    <div class="form-check">
                      <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="Sex" value="Female">
                        Hembra
                      </label>
                    </div>
                </div>

                <div class="col-lg-12"><br></div>

                <div class="col-lg-4">
                    <h4>Veterano</h4>
                </div>
                
                <div class="col-lg-8">
                    <div class="form-check">
                      <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="Veteran" value="Yes" checked>
                        Si
                      </label>
                    </div>
                    <div class="form-check">
                      <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="Veteran" value="No">
                        No
                      </label>
                    </div>
                </div>

                <div class="col-lg-12"></div>

                <div class="col-lg-4">
                    <h4>Clasificacion</h4>
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
                    <h4>Clasificacion de Escuela</h4>
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
                @endif

                <div class="col-lg-12"><br></div>

                <div class="col-lg-12">
                    <center>
                    <div id="signature-pad" class="signature-pad">
                        <div class="signature-pad--body">
                            <canvas></canvas>
                        </div>
                        <div class="signature-pad--footer">
                            <div class="description">Firma</div>
                            <div class="signature-pad--actions">
                                <div>
                                <button type="button" class="button clear" data-action="clear">Limpiar</button>
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
                        <button type="submit" onclick="signature()">Someter</button>
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