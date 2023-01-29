@extends("admin.layout.master")
@section('contenedor')

<h3>Requerimiento  <strong># {{$requermiento->id}}</strong> <a class="btn btn-danger pull-right" href="{{route("admin.lista_requerimientos")}}" onclick="">Volver listado</a></h3>

{!! Form::model($requermiento,["route"=>"admin.actualizar_compensacion"]) !!}
{!! Form::hidden("id",null) !!}


<h3>{{$cliente->nombre}}</h3>
<div class="clearfix"></div>
<h4 class="titulo1">INFORMACIÓN SOBRE LA EMPRESA CLIENTE</h4>

<div class="row">
    <div class="col-md-12 form-group">
        <label for="inputEmail3" class="col-sm-2 control-label">Tipo de Solicitud</label>
        <div class="col-sm-10">
            {!! Form::select("tipo_proceso_id",$tipoProceso,$requermiento->tipo_proceso_id,["class"=>"form-control"]); !!}
            
        </div>
    </div>
    <div class="col-md-6 form-group">

        <label for="inputEmail3" class="col-sm-4 control-label">Ciudad Trabajo</label>
        <div class="col-sm-8">
            {!! Form::hidden("pais_id",null,["class"=>"form-control","id"=>"pais_id"]) !!}
                {!! Form::hidden("ciudad_id",null,["class"=>"form-control","id"=>"ciudad_id"]) !!}
                {!! Form::hidden("departamento_id",null,["class"=>"form-control","id"=>"departamento_id"]) !!}
            {!! Form::text("ciudad_autocomplete",$requermiento->getUbicacion()->ciudad,["placeholder"=>"Seleccione la ciudad","class"=>"form-control","id"=>"ciudad_autocomplete"]) !!}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12 form-group">
        <label for="inputEmail3" class="col-sm-2 control-label">Unidad de Negocio</label>
        <div class="col-sm-10">
            {!! Form::text("contacto",$requermiento->getUnidadNegocio(),["class"=>"form-control","readonly"=>true,"readonly"=>true]); !!}
        </div>
    </div>
</div>

<h4 class="titulo1">NEGOCIO</h4>
<div class="row">
    <div class="col-md-6 form-group">
        <label for="inputEmail3" class="col-sm-4 control-label">Producción / Administrativos</label>
        <div class="col-sm-8">
            {!! Form::text("contacto",$negocio->getGerencia->descripcion,["class"=>"form-control","readonly"=>true,"readonly"=>true]); !!}
        </div>
    </div>
    <div class="col-md-6 form-group">
        <label for="inputEmail3" class="col-sm-4 control-label">Sociedad</label>
        <div class="col-sm-8">
            {!! Form::text("contacto",$negocio->getSociedades->division_nombre,["class"=>"form-control","readonly"=>true,"readonly"=>true]); !!}
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6 form-group">
        <label for="inputEmail3" class="col-sm-4 control-label">Negocio / Gerencia</label>
        <div class="col-sm-8">
            {!! Form::text("contacto",$negocio->nombre_negocio,["class"=>"form-control","readonly"=>true,"readonly"=>true]); !!}
        </div>
    </div>
    <div class="col-md-6 form-group">
        <label for="inputEmail3" class="col-sm-4 control-label">Tipo / Depto</label>
        <div class="col-sm-8">
            {!! Form::text("contacto",$cliente->contacto,["class"=>"form-control","readonly"=>true,"readonly"=>true]); !!}
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6 form-group">
        <label for="inputEmail3" class="col-sm-4 control-label">Centro Costo / Area</label>
        <div class="col-sm-8">
            {!! Form::text("contacto",$cliente->contacto,["class"=>"form-control","readonly"=>true,"readonly"=>true]); !!}
        </div>
    </div>
    <div class="col-md-6 form-group">
        <label for="inputEmail3" class="col-sm-4 control-label">Nombre Solicitante</label>
        <div class="col-sm-8">
            {!! Form::text("contacto",strtoupper($user->name),["class"=>"form-control","readonly"=>true,"readonly"=>true]); !!}
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6 form-group">
        <label for="inputEmail3" class="col-sm-4 control-label">Num. Requi Cliente</label>
        <div class="col-sm-8">
            {!! Form::text("num_req_cliente",$requermiento->num_req_cliente,["class"=>"form-control","readonly"=>true]); !!}

        </div>
    </div>
    <div class="col-md-6 form-group">
        <label for="inputEmail3" class="col-sm-4 control-label">Teléfono</label>
        <div class="col-sm-8">
            {!! Form::text("contacto",$requermiento->telefono_solicitante,["class"=>"form-control","readonly"=>true]); !!}
        </div>
    </div>
</div>

<h4 class="titulo1">ESPECIFICACIONES DEL REQUERIMIENTO</h4>
<div class="row">
    <div class="col-md-12 form-group">
        <label for="inputEmail3" class="col-sm-2 control-label">Cargo Cliente</label>
        <div class="col-sm-10">

            {!! Form::select("cargo_especifico_id",$cargo_especifico,$requermiento->cargo_especifico_id,["class"=>"form-control","id"=>"cargo_especifico_id"]); !!}

        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6 form-group">
        <label for="inputEmail3" class="col-sm-4 control-label">Centro de Trabajo</label>
        <div class="col-sm-8">
            
            {!! Form::select("ctra_x_clt_codigo",$centro_trabajo,$requermiento->ctra_x_clt_codigo,["class"=>"form-control","id"=>"ctra_x_clt_codigo"]); !!}
        </div>
    </div>
    <div class="col-md-6 form-group">
        <label for="inputEmail3" class="col-sm-4 control-label">CenCos Contable</label>
        <div class="col-sm-8">
            {!! Form::text("contacto",$cliente->contacto,["class"=>"form-control","readonly"=>true]); !!}
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6 form-group">
        <label for="inputEmail3" class="col-sm-4 control-label">CenCos Producción</label>
        <div class="col-sm-8">
            {!! Form::text("contacto",$cliente->contacto,["class"=>"form-control","readonly"=>true]); !!}
        </div>
    </div>
    <div class="col-md-6 form-group">
        <label for="inputEmail3" class="col-sm-4 control-label">Jornada Laboral</label>
        <div class="col-sm-8">
             {!! Form::select("tipo_jornadas_id",$tipoJornadas,$requermiento->tipo_jornadas_id,["class"=>"form-control","id"=>"tipo_jornadas_id"]); !!}
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6 form-group">
        <label for="inputEmail3" class="col-sm-4 control-label">Tipo Liquidación</label>
        <div class="col-sm-8">
             {!! Form::select("tipo_liquidacion",$tipo_liquidacion,$requermiento->tipo_liquidacion,["class"=>"form-control","id"=>"tipo_liquidacion"]); !!}
        </div>
    </div>
   
</div>

<div class="row">
    <div class="col-md-6 form-group">
        <label for="inputEmail3" class="col-sm-4 control-label">Tipo Salario</label>
        <div class="col-sm-8">
            {!! Form::select("tipo_salario",$tipo_salario,$requermiento->tipo_salario,["class"=>"form-control","id"=>"tipo_salario"]); !!}
        </div>
    </div>
    <div class="col-md-6 form-group">
        <label for="inputEmail3" class="col-sm-4 control-label">Tipo Nómina</label>
        <div class="col-sm-8">
            {!! Form::select("tipo_nomina",$tipo_nomina,$requermiento->tipo_nomina,["class"=>"form-control","id"=>"tipo_nomina"]); !!}
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6 form-group">
        <label for="inputEmail3" class="col-sm-4 control-label">Concepto Pago</label>
        <div class="col-sm-8">
            {!! Form::select("concepto_pago_id",$concepto_pago_id,$requermiento->concepto_pago_id,["class"=>"form-control","id"=>"concepto_pago_id"]); !!}
        </div>
    </div>
    <div class="col-md-6 form-group has-success">
        <label for="inputEmail3" class="col-sm-4 control-label">Salario</label>
        <div class="col-sm-8">
            {!! Form::text("salario",$requermiento->salario,["class"=>"form-control"]); !!}
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6 form-group">
        <label for="inputEmail3" class="col-sm-4 control-label">Tipo Contrato</label>
        <div class="col-sm-8">              
            {!! Form::select("tipo_contrato_id",$tipoContrato,$requermiento->tipo_contrato_id,["class"=>"form-control","id"=>"tipo_contrato_id"]); !!}

        </div>
    </div>
    <div class="col-md-6 form-group">
        <label for="inputEmail3" class="col-sm-4 control-label">Motivo Requerimiento</label>
        <div class="col-sm-8">

            {!! Form::select("motivo_requerimiento_id",$motivoRequerimiento,$requermiento->motivo_requerimiento_id,["class"=>"form-control","id"=>"motivo_requerimiento_id"]); !!}

        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6 form-group">
        <label for="inputEmail3" class="col-sm-4 control-label">Número Vacantes</label>
        <div class="col-sm-8">
            {!! Form::text("num_vacantes",$requermiento->num_vacantes,["class"=>"form-control","id"=>"num_vacantes"]); !!}

        </div>
    </div>
    <div class="col-md-6 form-group">
        <label for="inputEmail3" class="col-sm-4 control-label">Adicionales/Observaciones</label>
        <div class="col-sm-8">
            {!! Form::text("contacto",$requermiento->observaciones,["class"=>"form-control"]); !!}
        </div>
    </div>
</div>

<h4 class="titulo1">ESTUDIOS</h4>

<div class="row">
    <div class="col-md-6 form-group">
        <label for="inputEmail3" class="col-sm-4 control-label">Nivel Estudio</label>
        <div class="col-sm-8">
            {!! Form::text("contacto",$requermiento->getNivelEstudio()->descripcion,["class"=>"form-control","readonly"=>true]); !!}
        </div>
    </div>
    <div class="col-md-6 form-group">
        <label for="inputEmail3" class="col-sm-4 control-label">Funciones a Realizar</label>
        <div class="col-sm-8">
            {!! Form::text("contacto",$requermiento->funciones,["class"=>"form-control"]); !!}
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6 form-group">
        <label for="inputEmail3" class="col-sm-4 control-label">Edad Mínima</label>
        <div class="col-sm-8">
            {!! Form::text("contacto",$requermiento->edad_minima,["class"=>"form-control","readonly"=>true]); !!}
        </div>
    </div>
    <div class="col-md-6 form-group">
        <label for="inputEmail3" class="col-sm-4 control-label">Edad Máxima</label>
        <div class="col-sm-8">
            {!! Form::text("contacto",$requermiento->edad_maxima,["class"=>"form-control","readonly"=>true]); !!}
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6 form-group">
        <label for="inputEmail3" class="col-sm-4 control-label">Género</label>
        <div class="col-sm-8">
            {!! Form::text("contacto",$requermiento->genero_id,["class"=>"form-control","readonly"=>true]); !!}
        </div>
    </div>
    <div class="col-md-6 form-group">
        <label for="inputEmail3" class="col-sm-4 control-label">Estado Civil</label>
        <div class="col-sm-8">
            {!! Form::text("contacto",$requermiento->estado_civil,["class"=>"form-control","readonly"=>true]); !!}
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6 form-group">
        <label for="inputEmail3" class="col-sm-4 control-label">Fecha Ingreso</label>
        <div class="col-sm-8">
            {!! Form::text("fecha_ingreso",$requermiento->fecha_ingreso,["class"=>"form-control", "id"=>"fecha_ingreso"]); !!}
        </div>
    </div>
    <div class="col-md-6 form-group">
        <label for="inputEmail3" class="col-sm-4 control-label">Fecha Retiro</label>
        <div class="col-sm-8">
            {!! Form::text("fecha_retiro",$requermiento->fecha_retiro,["class"=>"form-control","id"=>"fecha_retiro","disabled"]); !!}
        </div>
    </div>
</div>

<h4 class="titulo1">SOPORTE SOLICITUD DE REQUISICION DEL CLIENTE</h4>

<div class="row">
    <div class="col-md-6 form-group">
        <label for="inputEmail3" class="col-sm-4 control-label">Fecha Recepción Solicitud</label>
        <div class="col-sm-8">
            {!! Form::text("contacto",$requermiento->fecha_recepcion,["class"=>"form-control","readonly"=>true]); !!}
        </div>
    </div>
    {{-- <div class="col-md-6 form-group">
        <label for="inputEmail3" class="col-sm-4 control-label">Contenido Email Soporte</label>
        <div class="col-sm-8">
            {!! Form::text("contacto",$requermiento->contenido_email_soporte,["class"=>"form-control"]); !!}
        </div>
    </div> --}}
</div>
{{-- @if($user->hasAccess("admin.info_facturacion"))
    <h4 class="box-header with-border">ESQUEMAS</h4>
    <div class="row">
        <div class="col-md-6 form-group">
            <div class="col-sm-12">
                <label class="form-check-label"> Seleccionar esquemas</label>
            </div>
            <div class="col-sm-12">
                {!! Form::radio("esquemas",1,0,["class"=>"form-check-input"]) !!}
                <label class="form-check-label"> Esquema 1 (30% -70%)</label>
            </div>
            <div class="col-sm-12">
                {!! Form::radio("esquemas",2,0,["class"=>"form-check-input"]) !!}
                <label class="form-check-label"> Esquema 2 (50% - 50%)</label>
            </div>
            <div class="col-sm-12">
                {!! Form::radio("esquemas",3,0,["class"=>"form-check-input"]) !!}
                <label class="form-check-label"> Esquema 3 (100%)</label>
            </div>
        </div>
    </div>
@endif --}}

{{-- <h4 class="titulo1">CANDIDATOS POSTULADOS</h4>
<div class="container" id="postulados">
  <div class="row">
    <div class="col-md-12 form-group">
      <table class="table">
        <thead>
          <tr>
            <th>#</th>
            <th>Nombre</th>
            <th>Cédula</th>
            <th>Télefono</th>
            <th>Móvil</th>
            <th>E-mail</th>
          </tr>
        </thead>
        @foreach ($candidatos_postulados as $count => $candidatos)
        <tbody>
          <tr>
            <td>{{ ++$count }}</td>
            <td>{{ $candidatos -> nombres }}</td>
            <td>{{ $candidatos -> cedula }}</td>
            <td>{{ $candidatos -> telefono }}</td>
            <td>{{ $candidatos -> celular }}</td>
            <td>{{ $candidatos -> email }}</td>
          </tr>
        </tbody>
        @endforeach
       </table>
    </div>
  </div>
</div> --}}

</br>


<a class="btn btn-warning" href="{{route("admin.lista_requerimientos")}}" onclick="">Volver listado</a>

    <button class="btn btn-success"  onclick="">Asignar compensación</button>

    <button type="button" class="btn btn-danger no_asignar" id="no_asignar" data-req_id={{$requermiento->id}}> No asignar compensación</button>


{!! Form::close() !!}
<script>
    $(function () {

          $("#no_asignar").on("click", function () {
            mensaje_success('Espere mientras se envian las notificaciones.') ;
            $.ajax({
                type: "POST",
                data: "req_id={{$requermiento->id}}",
                url: "{{route('admin.no_asignar')}}",
                success: function (response) {

                mensaje_success('Se envío notificación de no compensación.');
                location.reload();           
               
                }
            });
        });
        $('#cargo_especifico_id').change(function(e){
            alert('modificar cargos alerta');
        })
        var calendarOption = {
            dateFormat: "yy-mm-dd",
            dayNames: ["Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado"],
            dayNamesMin: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],
            monthNames: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
            monthNamesShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"],
            onSelect: function (dateText, obj) {
                console.log(dateText);
            }
        };
        var calendarOption2 = {
            dateFormat: "yy-mm-dd",
            dayNames: ["Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado"],
            dayNamesMin: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],
            monthNames: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
            monthNamesShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"]
        };
        $("#fecha_ingreso").datepicker(calendarOption);
        $("#fecha_retiro").datepicker(calendarOption2);

        $('#ciudad_autocomplete').autocomplete({
            serviceUrl: '{{ route("autocomplete_cuidades") }}',
            autoSelectFirst: true,
            onSelect: function (suggestion) {
                $("#pais_id").val(suggestion.cod_pais);
                $("#departamento_id").val(suggestion.cod_departamento);
                $("#ciudad_id").val(suggestion.cod_ciudad);
            }
        });
    });
</script>
@stop