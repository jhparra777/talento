@extends("admin.layout.master")
@section('contenedor')
<h3>Lista Usuarios Escaneados</h3>
<br>

    {!! Form::model(Request::all(),["route"=>"admin.lista_carga_scanner_l","method"=>"GET"]) !!}
    
        <div class="alert alert-warning alert-dismissible" role="alert">
            {{-- <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button> --}}
                   
            <p>
                <b>NOTA:</b>  Para los usuarios nuevos escaneados es obligatorio terminar de llenar la información básica de la hoja de vida para realizar otros procesos.
            </p>

        </div>
 
        @if(Session::has("errores_global") && count(Session::get("errores_global")) > 0)
            <div class="col-md-12" id="mensaje-resultado">
                <div class="divScroll">
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        
                        @foreach(Session::get("errores_global") as $key => $value)
                            <p>EL registro de la fila numero {{++$key}} tiene los siguientes errores</p>
                            <ul>
                                @foreach($value as $key2 => $value2)
                                    <li>{{$value2}}</li>
                                @endforeach
                            </ul>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

        @if(Session::has("mensaje_success"))
            <div class="col-md-12" id="mensaje-resultado">
                <div class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        {{Session::get("mensaje_success")}}
                </div>
            </div>
        @endif

        <div class="col-md-6 form-group">
            <label class="col-sm-2 control-label" for="inputEmail3">
                Número Cédula
            </label>
            <div class="col-sm-10">
                {!! Form::text("identificacion",null,[ "id"=>"identificacion", "class"=>"form-control" ]); !!}
                <p class="text-danger">{!! FuncionesGlobales::getErrorData("identificacion",$errors) !!}</p>
            </div>
        </div>

        <div class="col-md-6 form-group">
            <label class="col-sm-2 control-label" for="inputEmail3">
                Edad Inicial :
            </label>
            <div class="col-sm-10">
                {!! Form::number("edad_inicial",null,[ "id"=>"edad_inicial", "class"=>"form-control","placeholder"=>"Escriba la edad inical" ]); !!}
            </div>
        </div>

        <div class="col-md-6 form-group">
            <label class="col-sm-2 control-label" for="inputEmail3">
                Género
            </label>
            <div class="col-sm-10">
                {!! Form::text("genero",null,["class"=>"form-control","id"=>"genero" ]); !!}
                <p class="text-danger">{!! FuncionesGlobales::getErrorData("genero",$errors) !!}</p>        
            </div>
        </div>

        <div class="col-md-6 form-group">
            <label class="col-sm-2 control-label" for="inputEmail3">
                Edad Final :
            </label>
            <div class="col-sm-10">
                {!! Form::number("edad_final",null,[ "id"=>"edad_final", "class"=>"form-control","placeholder"=>"Escriba la edad final" ]); !!}
            </div>
        </div>

        <div class="col-md-6 form-group">
            <label class="col-sm-2 control-label" for="inputEmail3">
                Fecha inicial
            </label>
            <div class="col-sm-10">
                {!! Form::text("fecha_actualizacion_ini",null,["class"=>"form-control","placeholder"=>"Fecha de escaneo","id"=>"fecha_actualizacion_ini" ]); !!}
                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("fecha_actualizacion_ini",$errors) !!}</p>
            </div>
        </div>

        <div class="col-md-6 form-group">
            <label class="col-sm-2 control-label" for="inputEmail3">
                Fecha Final
            </label>
            <div class="col-sm-10">
                {!! Form::text("fecha_actualizacion_fin",null,["class"=>"form-control","placeholder"=>"Fecha de escaneo","id"=>"fecha_actualizacion_fin" ]); !!}
                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("fecha_actualizacion_fin",$errors) !!}</p>
            </div>
        </div>

        <div class="clearfix"></div>

        {!! Form::submit("Buscar",["class"=>"btn btn-success"]) !!}
        
        <a class="btn btn-danger" href="{{route("admin.lista_carga_scanner_l")}}">Limpiar</a>
        <a class="btn btn-warning" href="{{route("admin.lista_carga_scanner")}}">Volver</a>
    {!! Form::close() !!}

    <br><br><br>
    
    {!! Form::model(Request::all(),["route"=>"admin.enviar_requerimiento_scanner","method"=>"POST"]) !!}
    
        <div class="clearfix"></div>

        {!! Form::submit("Enviar a requerimiento",["style"=>"position:relative; left:-30px; top:-5px;","class"=>"btn btn-primary"]) !!}

        <div class="col-md-6 form-group">
            <label for="inputEmail3" class="col-sm-3 control-label">Requerimiento:</label>
                <div class="col-sm-8">
                    {!! Form::select("req_id",$requerimientos,null,["class"=>"form-control chosen1","id"=>"req" ]); !!}
                    <p class="text-danger">{!! FuncionesGlobales::getErrorData("req_id",$errors) !!}</p>
                </div>
        </div>

        <br>

        <div class="clearfix"></div>

        <div class="tabla table-responsive">
            <table class="table table-bordered table-hover ">
                <thead>
                    <tr>
                        <th></th>
                        <th>
                            <div class="checkbox" style="top:10px;">
                                {!! Form::checkbox("seleccionar_todos",null,false,["id"=>"seleccionar_todos"]) !!} Seleccionar 
                            </div>
                        </th>
                        <th style="text-align: center;">Identificación</th>
                        <th style="text-align: center;">Nombres</th>
                        <th style="text-align: center;">Apellidos</th>
                        <th style="text-align: center;">Género</th>
                        <th style="text-align: center;">Tipo de Sangre</th>
                        <th style="text-align: center;">Fecha de escaneo</th>
                        <th style="text-align: center;">Edad</th>
                        <th style="text-align: center;">Fecha de Nacimiento</th>
                        <th style="text-align: center;">¿Citado?</th>
                        <!--<th>Usuario Carga</th>-->
                    </tr>
                </thead>
                <tbody>
                    @if($personas_scanner->count() == 0)
                        <tr>
                            <td colspan="5">No se encontraron registros</td>
                        </tr>
                    @endif

                    @foreach($personas_scanner as $key => $personas)
                        <tr>
                            <td>{{++$key }}</td>
            
                            <td>
                                {!! Form::checkbox("user_carga[]",$personas->user_carga,null,["data-url"=>route('admin.editar_cliente'),"style"=>'text-align: center;']) !!}
                                <p class="text-danger">{!! FuncionesGlobales::getErrorData("user_carga",$errors) !!}</p>
                            </td>
                            <td style="text-align: center;">{{$personas->identificacion }}</td>
                            <td style="text-align: center;">{{ strtoupper($personas->primer_nombre." ".$personas->segundo_nombre) }}</td>
                            <td style="text-align: center;">{{ strtoupper($personas->primer_apellido." ".$personas->segundo_apellido) }}</td>
                            <td style="text-align: center;">{{ $personas->genero }}</td>
                            <td style="text-align: center;" >{{ $personas->rh }}</td>
                            <td style="text-align: center;">{{ $personas->created_at}}</td>
                            <td style="text-align: center;">{{ $personas->edad }}</td>
                            <td style="text-align: center;">{{ $personas->fecha }}</td>
                            <td style="text-align: center;">{{(($personas->req_id==true)?"Si (Req:" .$personas->req_id.")":"No")}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div>
            {!!$personas_scanner->appends(Request::all())->render() !!}
        </div>

    {!! Form::close() !!}

    <script>
        
        $(".chosen1").chosen();

        $("#seleccionar_todos").on("change", function () {
            var obj = $(this);
            $("input[name='user_carga[]']").prop("checked", obj.prop("checked"));
        });


    	$("#fecha_actualizacion_fin").datepicker(confDatepicker);
          $("#fecha_actualizacion_ini").datepicker(confDatepicker);

           $('#ciudad_autocomplete').autocomplete({
                serviceUrl: '{{ route("autocomplete_cuidades") }}',
                autoSelectFirst: true,
                onSelect: function (suggestion) {
                    $("#pais_id").val(suggestion.cod_pais);
                    $("#departamento_id").val(suggestion.cod_departamento);
                    $("#ciudad_id").val(suggestion.cod_ciudad);
                }
            });
    </script>

    <style >
        #req{
            width: 200px !important;
        }
        .chosen-container .chosen-container-single{
            width: 200px !important;
        }
    </style>

@stop