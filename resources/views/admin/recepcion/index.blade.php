@extends("admin.layout.master")
@section("contenedor")
{!! Form::model(Request::all(),["route"=>"admin.recepcion","method"=>"get"]) !!}
<h3>Recepción</h3>
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
        {!! Session::get("mensaje_error") !!}
    </div>
</div>
@endif
<div class="col-md-12 form-group">
    <label for="inputEmail3" class="col-sm-2 control-label">Cédula:</label>
    <div class="col-sm-10">
        {!! Form::text("cedula",null,["class"=>"form-control","placeholder"=>"No. Cédula" ]); !!}
    </div>
    <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("cedula",$errors) !!}</p>    
</div>
{!! Form::submit("Buscar",["class"=>"btn btn-success"]) !!}
{!! Form::close() !!}
@if(isset($candidato))

{!! Form::model($candidato,["method"=>"POST","route"=>"admin.iniciar_proceso_recepcion", "id"=>"form_recepcion"]) !!}
<h3>Datos Candidatos</h3>
@if(!isset($candidato->id))
<div role="alert" class="alert alert-danger"> 
    <strong>El usuario no se encuentra registrado en el sistema.</strong>  
</div>
@endif
@if($procesoIniciado->count() > 0)
<div role="alert" class="alert alert-warning"> 
    <strong>El usuario ya tiene un proceso.</strong>  
</div>
@endif

@if($citacion->count() > 0)
<div role="alert" class="alert alert-success"> 
    <strong>El usuario tiene citación.</strong>
    <table class="table">
            <tr>
                <th>Asistir</th>
                <th>Motivo</th>
                <th>Fecha</th>
            </tr>
            @foreach($citacion as $cita)
            <tr>
                <td>
                    {!! Form::checkbox('asistencia', 1, null) !!}
                </td>
                <td> {{ $cita->getCitacionMotivo() }} </td>
                <td> {{ $cita->fecha_cita }} {{ $cita->HoraCita() }}</td>
            </tr>
            @endforeach
    </table>
</div>
@endif

@if($candidato->estado_reclutamiento == config('conf_aplicacion.PROBLEMA_SEGURIDAD') )
    <div style="background-color: red; height: 50px"></div>
@else


    {!! Form::hidden("id",null) !!}
    {!! Form::hidden("user_id",null) !!}
    <div class="row">
        <div class="form-group col-md-6">
            {!! Form::label('identificacion', 'Cédula') !!}
            {!! Form::text('numero_id',null,['class'=>'form-control','id'=>'identificacion','placeholder'=>'# Identificación','value'=>old('identificacion')]) !!}
            <p class="text-danger">{!! FuncionesGlobales::getErrorData("numero_id",$errors) !!}</p>
        </div>
        <div class="form-group col-md-6">
            {!! Form::label('name', 'Nombres') !!}
            {!! Form::text('nombres',null,['class'=>'form-control','id'=>'name','placeholder'=>'Nombres','value'=>old('name')]) !!}
            <p class="text-danger">{!! FuncionesGlobales::getErrorData("name",$errors) !!}</p>
        </div>

        <div class="col-md-6">

            <div class="form-group">
                {!! Form::label('primer_apellido', 'Primer Apellido') !!}
                {!! Form::text('primer_apellido',null,['class'=>'form-control','id'=>'primer_apellido','placeholder'=>'Primer Apellido','value'=>old('primer_apellido')]) !!}
                <p class="text-danger">{!! FuncionesGlobales::getErrorData("primer_apellido",$errors) !!}</p>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {!! Form::label('segundo_apellido', 'Segundo Apellido') !!}
                {!! Form::text('segundo_apellido',null,['class'=>'form-control','id'=>'segundo_apellido','placeholder'=>'Segundo Apellido','value'=>old('segundo_apellido')]) !!}
                <p class="text-danger">{!! FuncionesGlobales::getErrorData("segundo_apellido",$errors) !!}</p>
            </div>
        </div>


        <div class="col-md-6">
            <div class="form-group">
                {!! Form::label('telefono_fijo', 'Teléfono Fijo') !!}
                {!! Form::text('telefono_fijo',null,['class'=>'form-control','id'=>'telefono_fijo','placeholder'=>'Teléfono Fijo','value'=>old('telefono_fijo')]) !!}
                <p class="text-danger">{!! FuncionesGlobales::getErrorData("telefono_fijo",$errors) !!}</p>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {!! Form::label('telefono_movil', 'Teléfono Móvil') !!}
                {!! Form::text('telefono_movil',null,['class'=>'form-control','id'=>'telefono_movil','placeholder'=>'Teléfono Móvil']) !!}
                <p class="text-danger">{!! FuncionesGlobales::getErrorData("telefono_movil",$errors) !!}</p>
            </div>
        </div>

        <div class="col-md-6">
            {!! Form::label('email', 'Correo Electrónico') !!}
            {!! Form::text('email',null,['class'=>'form-control','id'=>'email','placeholder'=>'Correo Electrónico','value'=>old('email')]) !!}
            <p class="text-danger">{!! FuncionesGlobales::getErrorData("email",$errors) !!}</p>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                {!! Form::label('motivo', 'Motivo') !!}
                {!! Form::select("motivo",$tipos_motivos,null,["class"=>"form-control","id"=>"motivo","onclick"=>"mostrarReferencia();"]) !!}
                <p class="text-danger">{!! FuncionesGlobales::getErrorData("motivo",$errors) !!}</p>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                {!! Form::label('documento_deja', 'Documento Deja') !!}
                {!! Form::select("documento_deja",$tipos_documentos,null,["class"=>"form-control","id"=>"documento_deja"]) !!}
                <p class="text-danger">{!! FuncionesGlobales::getErrorData("documento_deja",$errors) !!}</p>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                {!! Form::label('numero_ficha', 'Número Ficha') !!}
                {!! Form::text('numero_ficha',null,['class'=>'form-control','id'=>'numero_ficha','placeholder'=>'Número Ficha','value'=>old('numero_ficha')]) !!}
                <p class="text-danger">{!! FuncionesGlobales::getErrorData("numero_ficha",$errors) !!}</p>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                {!! Form::label('ciudad_trabajo', 'Ciudad de Trabajo') !!}
                {!! Form::select("ciudad_trabajo",$ciudad_trabajo,null,["class"=>"form-control","id"=>"ciudad_trabajo"]) !!}
                <p class="text-danger">{!! FuncionesGlobales::getErrorData("ciudad_trabajo",$errors) !!}</p>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                {!! Form::label('unidad', 'Área/ Departamento') !!}
                {!! Form::select("unidad",$unidad_trabajo,null,["class"=>"form-control","id"=>"unidad"]) !!}
                <p class="text-danger">{!! FuncionesGlobales::getErrorData("unidad",$errors) !!}</p>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                {!! Form::label('usuario_seleccion', 'Usuario Selección') !!}
                {!! Form::select("usuario_seleccion",$psicologos,null,["class"=>"form-control","id"=>"usuario_seleccion"]) !!}
                <p class="text-danger">{!! FuncionesGlobales::getErrorData("usuario_seleccion",$errors) !!}</p>
            </div>
        </div>

        <div class="col-md-6"></div>

        <div class="col-md-3">
            <div style="display: flex;align-items:center;">
                {!! Form::label('Perfilamiento', 'Perfilamiento') !!}  &nbsp;&nbsp;
                {!! Form::hidden("perfilamiento",(($v_perfilamiento == null)?0:1)) !!}
                @if($v_perfilamiento == null)
                <span class="fa fa-times-circle-o fa-3x text-danger "></span>
                @else
                <span class="fa fa-check-circle-o  fa-3x text-success "></span>
                @endif
            </div>
        </div>
        <div class="col-md-3">
            <div style="display: flex;align-items:center;">
                {!! Form::label('Pruebas', 'Pruebas') !!} &nbsp;&nbsp;
                {!! Form::hidden("pruebas",$v_pruebas) !!}
                @if($v_pruebas == 0)
                <span class="fa fa-times-circle-o fa-3x text-danger "></span>
                @else
                <span class="fa fa-check-circle-o  fa-3x text-success "></span>
                @endif
            </div>
        </div>
    </div>
    <div class="col-md-12" id="oculto_inicio" style="display:none;">
        @if($control == 3)
            <button class="btn btn-success pull-right col-md-6 control_ingreso" type="button">Registro Ingreso</button>
            {!! Form::hidden("cd_recepcion",0) !!}
        @else
            <button class="btn btn-success pull-right col-md-6 control_ingreso" type="button">Registro Salida</button>
            {!! Form::hidden("cd_recepcion",1) !!}
            {!! Form::hidden("id_control",$id_control) !!}  
        @endif
    </div>

    <div class="col-md-12" id="oculto_inicio_proceso" style="display:none;">
        @if($control_b == 1)
            @if($v_pruebas !== 0 && $v_perfilamiento !== 0)
                {!! FuncionesGlobales::valida_boton_req("admin.iniciar_proceso_recepcion","Iniciar Proceso","submit","btn btn-danger pull-right col-md-6") !!}
            @endif
        @else
            @if($v_pruebas !== 0 && $v_perfilamiento !== 0)
                {!! FuncionesGlobales::valida_boton_req("admin.salida_proceso_recepcion","Registrar Salida","boton","btn btn-danger pull-right col-md-6 salida_proceso") !!}
                {!! Form::hidden("id_control_b",$id_control_b) !!} 
            @endif
        @endif
    </div>
@endif
{!! Form::close() !!}
@endif
<script type="text/javascript">

    $(".control_ingreso").on("click", function () {
            $.ajax({
                type: "POST",
                data: $("#form_recepcion").serialize(),
                url: "{{route('admin.guardar_ingreso')}}",
                success: function (response) {
                    if (response.success) {
                        mensaje_success(response.mensaje);
                        location.reload();
                    }else{
                        mensaje_danger("Problemas al registrar el control de recepcion.");
                    }
                }
            });
        });

    $(".salida_proceso").on("click", function () {
            $.ajax({
                type: "POST",
                data: $("#form_recepcion").serialize(),
                url: "{{route('admin.salida_proceso_recepcion')}}",
                success: function (response) {
                    if (response.success) {
                        mensaje_success(response.mensaje);
                        location.reload();
                    }else{
                        mensaje_danger("Problemas al registrar el control de recepcion.");
                    }
                }
            });
        });

    function mostrarReferencia(){

        valor = $("#motivo").val();
        //alert(valor);
        if(valor == 2) {
            document.getElementById('oculto_inicio_proceso').style.display='block';
        }else{
            document.getElementById('oculto_inicio_proceso').style.display='none';
        }

        if(valor != 2 && valor !=""){
            document.getElementById('oculto_inicio').style.display='block';
        }else{
            document.getElementById('oculto_inicio').style.display='none';
        }
    }

</script>

@stop