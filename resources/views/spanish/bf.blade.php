@extends('layout')

@section('title')
    Horsepower - Fondos de Beneficios
@stop

@section('content')

        <div class="container content">

            <div class="col-lg-12"> 
                <center>
                    <h1>
                        Fondos de Beneficios
                    </h1>

                    <a class="btn btn-primary" href="english"><h6>To English</h6></a>

                </center>
            </div>

            <form class="form-horizontal" role="form" method="POST" action="{{ route('bfpdf', ['lang' => 'Spanish']) }}">
            
            {{ csrf_field() }}

            <input type="hidden" name="lang" value="0"/>

            <div class="col-lg-12">

                <div class="col-lg-12"><h3>Nombre Completo De Miembro</h3></div>

                <div class="col-lg-2">
                    <h4>Ultimo Nombre</h4>
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
                    <h4>Primer Nombre</h4>
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
                    <h4>Numero De Seguridad Social</h4>
                </div>

                <div class="col-lg-8">
                    {!! Form::text('SSN', '',
                        ['class' => 'form-control ssn',
                        ])  
                    !!}
                    @if($errors->has('SSN'))
                        <p class="red">Please enter a valid social security number.</p>
                    @endif
                </div>

                <div class="col-lg-12"><br></div>

                <div class="col-lg-4">
                    <h4>Numero De Telepono</h4>
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
                    <h4>Fecha De Nacimento</h4>
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
                    <h4>Correo Electronico</h4>
                </div>
                <div class="col-lg-8">
                    {!! Form::text('EMAIL', '',
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
                    <h4>Sexo</h4>
                </div>
                
                <div class="col-lg-3">
                    <div class="form-check">
                      <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="SEX" value="M" checked>
                        Hombre
                      </label>
                    </div>
                    <div class="form-check">
                      <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="SEX" value="F">
                        Mujer
                      </label>
                    </div>
                </div>

                <div class="col-lg-3">
                    <h4>Estado Civil</h4>
                </div>
                
                <div class="col-lg-3">
                    <div class="form-check">
                      <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="STATUS" value="MARRIED" checked>
                        Casado
                      </label>
                    </div>
                    <div class="form-check">
                      <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="STATUS" value="SINGLE">
                        Soltero
                      </label>
                    </div>
                    <div class="form-check">
                      <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="STATUS" value="DIVORCED">
                        Divorciado
                      </label>
                    </div>
                    <div class="form-check">
                      <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="STATUS" value="WIDOW">
                        Viuda/o
                      </label>
                    </div>
                </div>

                <div class="col-lg-12"><h3>Direccion</h3></div>

                <div class="col-lg-2">
                    <h4>Calle</h4>
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
                    <h4>Numero De Apartamento</h4>
                </div>
                <div class="col-lg-1">
                    {!! Form::number('APT', '',
                        ['class' => 'form-control',
                        ]) 
                    !!}
                </div>

                <div class="col-lg-12"></div>
                
                <div class="col-lg-2">
                    <h4>Ciudad</h4>
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
                    <h4>Estado</h4>
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
                    <h4>Codigo Postal</h4>
                </div>
                <div class="col-lg-3">
                    {!! Form::text('ZIP', '',
                        ['class' => 'form-control',
                        ]) 
                    !!}
                    @if($errors->has('ZIP'))
                        <p class="red">Please input the zip where you reside in.</p>
                    @endif
                </div>

                <div class="col-lg-12"><br></div>
                
                <div class="col-lg-4">
                    <h4>Nombre De Tienda</h4>
                </div>

                <div class="col-lg-8">
                    {!! Form::text('SHOP_NAME', 'Horsepower Electric',
                        ['class' => 'form-control', 'readonly' => true,
                        ]) 
                    !!}
                </div>

                <div class="col-lg-12"><br></div>

                <div class="col-lg-4">
                    <h4>Clase De Trabajo</h4>
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
                    <h4>Fecha Contratado</h4>
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

                <div class="col-lg-12"><center><h3>Complete lo siguiente para su conyuge y todo los hijos dependiente</h3></center></div>

                <div class="col-lg-12">
                    <table class="table table-bordered" style="min-width:500px">
                        <thead>
                            <td>#</td>
                            <td>Primero y Ultimo Nombre</td>
                            <td>Fecha De Nacimento</td>
                            <td>Sexo</td>
                            <td>Nombre De Seguridad Social</td>
                            <td>Relacion</td>
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

                <div class="col-lg-12"><center><h3>Si casada/o, complete esta seccion</h3></center></div>

                <div class="col-lg-4">
                    <h4>Fecha De Matrimonio</h4>
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
                    <h4>Ciudad, Estado, y Pais De Matrimonio</h4>
                </div>

                <div class="col-lg-8">
                    {!! Form::text('PLACE_MARRIED', '',
                        ['class' => 'form-control',
                        ]) 
                    !!}
                </div>

                <div class="col-lg-12"><center><h3>En caso de divorcio o separacion legal, complete esta seccion.</h3></center></div>

                <div class="col-lg-4">
                    <h4>Fecha De Divorcio/Separacion</h4>
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
                    <h4>Si ay un orden de corte que proporcione cobertura de salud para su dependientes?</h4>
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

                <div class="col-lg-12"><center><h3>Si su conyuge esta empleado, complete esta seccion</h3></center></div>

                <div class="col-lg-4">
                    <h4>Completo Nombre De Empleador De Su Conyuge</h4>
                </div>

                <div class="col-lg-8">
                    {!! Form::text('SPOUSE_EMPLOYER', '',
                        ['class' => 'form-control',
                        ]) 
                    !!}
                </div>

                <div class="col-lg-12"></div>

                <div class="col-lg-4">
                    <h4>Direccion De Empleadorr</h4>
                </div>

                <div class="col-lg-8">
                    {!! Form::text('SPOUSE_EMPLOYER_ADDRESS', '',
                        ['class' => 'form-control',
                        ]) 
                    !!}
                </div>

                <div class="col-lg-12"></div>

                <div class="col-lg-4">
                    <h4>Fecha Contratado</h4>
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
                    <h4>Telefono De Empleador</h4>
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

                <div class="col-lg-12"><center><h3>La persona(s) delcarada(s) serano beneficiadores de cualquier beneficio en que esoy entitulado despues de mi muerte.</h3></center></div>

                <div class="col-lg-12">
                    <table class="table table-bordered">
                        <thead>
                            <td>#</td>
                            <td>Primero y Ultimo Nombre</td>
                            <td>Nombre De Seguridad Social</td>
                            <td>Fecha De Nacimiento</td>
                            <td>Relacion</td>
                            <td>PCT.</td>
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