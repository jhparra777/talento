@extends("admin.layout.master")
@section("contenedor")
<div class="col-md-8 col-md-offset-2">
    {!! Form::open(["id"=>"fr_tipos_jornadas","route"=>"admin.tipos_jornadas.guardar","method"=>"POST"]) !!}
{!! Form::hidden("active",1,["class"=>"form-control","placeholder"=>"active" ]); !!}

    <h3>Nuevo   Tipos Jornadas</h3>
    <div class="clearfix"></div>
    @if(Session::has("mensaje_success"))
    <div class="col-md-12" id="mensaje-resultado">
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            {{Session::get("mensaje_success")}}
        </div>
    </div>
    @endif

    <div class="row">

        <div class="col-md-12 form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Descripcion:</label>
            <div class="col-sm-10">
                {!! Form::text("descripcion",null,["class"=>"form-control","placeholder"=>"descripcion" ]); !!}
            </div>
            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("descripcion",$errors) !!}</p>    
        </div>
        <div class="col-md-12 form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Hora Inicio:</label>
            <div class="col-sm-10">
                {!! Form::text("hora_inicio",null,["class"=>"form-control","placeholder"=>"hora_inicio","id"=>"hora_inicio" ]); !!}
            </div>
            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("hora_inicio",$errors) !!}</p>    
        </div><div class="col-md-12 form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Hora Fin:</label>
            <div class="col-sm-10">
                {!! Form::text("hora_fin",null,["class"=>"form-control","placeholder"=>"hora_fin","id"=>"hora_fin" ]); !!}
            </div>
            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("hora_fin",$errors) !!}</p>    
        </div><div class="col-md-12 form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Procentaje Horas:</label>
            <div class="col-sm-10">
                {!! Form::text("procentaje_horas",null,["class"=>"form-control","placeholder"=>"procentaje_horas" ]); !!}
            </div>
            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("procentaje_horas",$errors) !!}</p>    
        </div>

    </div>
    <div class="clearfix" ></div>

    {!! FuncionesGlobales::valida_boton_req("admin.tipos_jornadas.guardar","Guardar","submit","btn btn-success") !!}
    <a href="#" class="btn btn-warning" onclick="window.history.back()">Volver Listado</a>
    {!! Form::close() !!}
</div>
<script>
    $(function () {
        $('#hora_fin, #hora_inicio').timepicker({
            hourGrid: 4,
            minuteGrid: 10,
            timeFormat: 'hh:mm:ss',
            timeOnlyTitle:"Hora seleccionada",
            hourText:"Hora",
            minuteText:"Minutos",
            secondText:"segundos",
            showSecond:false,
            closeText:"cerrar",
            currentText:"Hora Actual"
        });

    });
</script>
@stop