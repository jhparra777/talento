@extends("admin.layout.master")
@section('contenedor')

    <h3>Guardar personas escaneadas</h3>
    <br>
    <div class="alert alert-warning alert-dismissible" >
 	  <p>Para empezar el proceso  de escaneo haga click en número de cédula y utilice el escaner para comenzar</p>
    </div>
 	
    {!! Form::model(Request::all(),["route"=>"admin.guardar_carga_scanner_fr","method"=>"POST"]) !!}

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

        @if(Session::has("mensaje_error"))
            <div class="col-md-12" id="mensaje-resultado">
                <div class="alert alert-danger alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    {{Session::get("mensaje_error")}}
                </div>
            </div>
        @endif


        <div class="col-md-6 form-group">
            <label class="col-sm-2 control-label" for="inputEmail3">

                Número Cédula
            </label>
             <div class="col-sm-10">
                {!! Form::text("identificacion",null,[ "autofocus","id"=>"identificacion", "class"=>"form-control" ]); !!}
                 <p class="text-danger">{!! FuncionesGlobales::getErrorData("identificacion",$errors) !!}</p>
            </div>
        </div>
        <div class="col-md-6 form-group">
            <label class="col-sm-2 control-label" for="inputEmail3">
               Primer Apellido
            </label>
            <div class="col-sm-10">
                {!! Form::text("primer_apellido",null,["class"=>"form-control","id"=>"primer_apellido" ]); !!}
                 <p class="text-danger">{!! FuncionesGlobales::getErrorData("primer_apellido",$errors) !!}</p>
                
            </div>
        </div>

        <div class="col-md-6 form-group">
            <label class="col-sm-2 control-label" for="inputEmail3">
               Segundo Apellido
            </label>
            <div class="col-sm-10">
                {!! Form::text("segundo_apellido",null,["class"=>"form-control","id"=>"segundo_apellido" ]); !!}
                 <p class="text-danger">{!! FuncionesGlobales::getErrorData("segundo_apellido",$errors) !!}</p>

                
            </div>
        </div>
        <div class="col-md-6 form-group">
            <label class="col-sm-2 control-label" for="inputEmail3">
               Primer Nombre
            </label>
            <div class="col-sm-10">
                {!! Form::text("primer_nombre",null,["class"=>"form-control","id"=>"primer_nombre" ]); !!}
                 <p class="text-danger">{!! FuncionesGlobales::getErrorData("primer_nombre",$errors) !!}</p>
              
            </div>
        </div>
        <div class="col-md-6 form-group">
            <label class="col-sm-2 control-label" for="inputEmail3">
               Segundo Nombre
            </label>
            <div class="col-sm-10">
                {!! Form::text("segundo_nombre",null,["class"=>"form-control","id"=>"segundo_nombre" ]); !!}
                 <p class="text-danger">{!! FuncionesGlobales::getErrorData("segundo_nombre",$errors) !!}</p>
                
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
              
            </label>
            <div class="col-sm-10">
               	
                
            </div>
        </div>

        <div class="col-md-6 form-group">
            <label class="col-sm-2 control-label" for="inputEmail3">
               Fecha de nacimiento
            </label>
            <div class="col-sm-10">
                {!! Form::text("fecha_nacimiento",null,["class"=>"form-control","id"=>"fecha_nacimiento" ]); !!}
                 <p class="text-danger">{!! FuncionesGlobales::getErrorData("fecha_nacimiento",$errors) !!}</p>
                
            </div>
        </div>
        <div class="col-md-6 form-group">
            <label class="col-sm-2 control-label" for="inputEmail3">
               Tipo de sangre
            </label>
            <div class="col-sm-10">
                {!! Form::text("rh",null,["class"=>"form-control","id"=>"rh" ]); !!}
                 <p class="text-danger">{!! FuncionesGlobales::getErrorData("rh",$errors) !!}</p>
                
            </div>
        </div>

        <div class="col-md-6 form-group">
            <label class="col-sm-2 control-label" for="inputEmail3">
               Fuente de Reclutamiento
            </label>
            <div class="col-sm-10">
                {!! Form::select("fuente_recl",$fuentesRec,null,["class"=>"form-control","id"=>"fuente_recl" ]); !!}
                 <p class="text-danger">{!! FuncionesGlobales::getErrorData("rh",$errors) !!}</p>
                
            </div>
        </div>

        <div class="col-md-6 form-group">
            <label class="col-sm-2 control-label" for="inputEmail3">
               EPS
            </label>
            <div class="col-sm-10">
                {!! Form::select("eps_select",$epsSelect,null,["class"=>"form-control","id"=>"eps_select"]); !!}
                 <p class="text-danger">{!! FuncionesGlobales::getErrorData("rh",$errors) !!}</p>
                
            </div>
        </div>
         <div class="col-md-6 form-group">
            <label class="col-sm-2 control-label" for="inputEmail3">
              Email
            </label>
            <div class="col-sm-10">
                {!! Form::text("email",null,["class"=>"form-control","id"=>"rh" ]); !!}
                 <p class="text-danger">{!! FuncionesGlobales::getErrorData("email",$errors) !!}</p>
                
            </div>
        </div>
         <div class="col-md-6 form-group">
            <label class="col-sm-2 control-label" for="inputEmail3">
              Telefono
            </label>
            <div class="col-sm-10">
                {!! Form::text("telefono",null,["class"=>"form-control","id"=>"rh" ]); !!}
                 <p class="text-danger">{!! FuncionesGlobales::getErrorData("telefono",$errors) !!}</p>
                
            </div>
        </div>

        <div class="col-md-6 form-group">
            <label class="col-sm-2 control-label" for="inputEmail3">
               N. de Emergencia
            </label>
            <div class="col-sm-10">
                {!! Form::text("num_emergencia",null,["class"=>"form-control","id"=>"num_emergencia","placeholder"=>"# de Emergencia"]); !!}
                 <p class="text-danger">{!! FuncionesGlobales::getErrorData("rh",$errors) !!}</p>
                
            </div>
        </div>


        <div class="clearfix"></div>

        <a class="btn btn-danger" href="{{route("admin.lista_carga_scanner_fr")}}">Limpiar</a>
        <a class="btn btn-warning" href="{{route("admin.lista_carga_scanner_l")}}">Lista de usuarios escaneados</a>

        {!! Form::submit("Guardar",["class"=>"btn btn-success"]) !!}

        <br>
        
    
    {!! Form::close() !!}

    <div class="clearfix"></div>
    <div class="tabla table-responsive">
        <table class="table table-bordered table-hover ">
            <thead>
                <tr>
            	
                    <th>Identificación</th>
                    <th>Nombres</th>
                    <th>Apellidos</th>
                    <th>Género</th>
                    <th>Tipo de sangre</th>
                    <th>Fecha de escaneo</th>
                    <th>Edad</th>
                    <th>Fecha de Nacimiento</th>
                    <th>Fuente Reclutamiento</th>
                    <th>EPS</th>
                    <th># Emergencia</th>
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
                    	<td>{{$personas->identificacion }}</td>
                        <td>{{ strtoupper($personas->primer_nombre." ".$personas->segundo_nombre) }}</td>
                        <td>{{ strtoupper($personas->primer_apellido." ".$personas->segundo_apellido) }}</td>
                        <td>{{ $personas->genero }}</td>
                        <td style="text-align: center;">{{ $personas->rh }}</td>
                        <td>{{ $personas->created_at}}</td>
                        <td>{{ $personas->edad }}</td>
                        <td>{{ $personas->fecha }}</td>
                        <td>{{ $personas->fuente_desc }}</td>
                        <td>{{ $personas->eps_desc }}</td>
                        <td>{{ $personas->num_emergencia }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div></div>


    <script>
        $(".chosen1").chosen();
        
        $("#seleccionar_todos").on("change", function () {
            var obj = $(this);
            $("input[name='user_id[]']").prop("checked", obj.prop("checked"));
        });
    </script>

@stop