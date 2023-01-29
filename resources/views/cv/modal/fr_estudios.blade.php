{!! Form::model($campos,["id"=>"fr_estudios","class"=>"form-horizontal form-datos-basicos", "role"=>"form"]) !!}
{!! Form::hidden("id",null) !!}
<div class="row">
    <h3 class="header-section-form"> <span class='text-danger sm-text'> Recuerde que los campos marcados con el símbolo (*) son obligatorios.</span></h3>
    <div class="col-md-12">
        <p class="text-primary set-general-font-bold">
            Por favor ingrese los datos de sus estudios, le recomendamos que registre desde su estudio más antiguo al más reciente y luego haga clic en Guardar.
        </p>
        <p class="direction-botones-left">
            <a href="#grilla_datos" class="btn btn-defecto btn-peq"><i class="fa fa-file-text"></i>&nbsp;Mis Estudios</a>
        </p>
    </div>
    <div class="col-sm-6 col-lg-12">
        <div class="form-group">
            <label for="trabajo-empresa-temporal" class="col-md-4 control-label">¿Estudia actualmente?:</label>
            <div class="col-md-6">
                {!! Form::checkbox("estudio_actual",1,null,["class"=>"checkbox-preferencias"]) !!}

            </div>
        </div>
        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("estudio_actual",$errors) !!}</p>
    </div>
    <div class="col-sm-6 col-lg-12">
        <div class="form-group">
            <label for="tipo_id" class="col-md-4 control-label">Nivel Estudios:<span class='text-danger sm-text-label'>*</span></label>
            <div class="col-md-6">
                {!! Form::select("nivel_estudio_id",$nivelEstudios,null,["class"=>"form-control"]) !!}

            </div>
        </div>
        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("nivel_estudio_id",$errors) !!}</p>
    </div>
    <div class="col-sm-6 col-lg-12">
        <div class="form-group">
            <label for="nombre_empresa_temporal" class="col-md-4 control-label">Institución:<span class='text-danger sm-text-label'>*</span> </label>
            <div class="col-md-6">

                {!! Form::text("institucion",null,["class"=>"form-control","placeholder"=>"Institución" ]) !!}
            </div>
        </div>
        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("institucion",$errors) !!}</p>
    </div>
<!--
    <div class="col-sm-6 col-lg-12">
        <div class="form-group">
            <label for="termino_estudios" class="col-md-4 control-label">Terminó Estudios:<span class='text-danger sm-text-label'>*</span> </label>
            <div class="col-md-6">
                {!! Form::checkbox("termino_estudios",1,null,["class"=>"checkbox-preferencias"]) !!}
            </div>
        </div>
        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("termino_estudios",$errors) !!}</p>
    </div>
-->
    <div class="col-sm-6 col-lg-12">
        <div class="form-group">
            <label for="titulo_obtenido" class="col-md-4 control-label">Titulo Obtenido: </label>
            <div class="col-md-6">
                {!! Form::text("titulo_obtenido",null,["class"=>"form-control", "id"=>"titulo_obtenido" ,"placeholder"=>"Titulo Obtenido" ]) !!}
            </div>
        </div>
        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("titulo_obtenido",$errors) !!}</p>
    </div>

    <div class="col-sm-6 col-lg-12">
        <div class="form-group">
            <label for="ciudad" class="col-md-4 control-label">Ciudad Estudio: </label>
            <div class="col-md-6">
                {!! Form::hidden("pais_estudio",null,["class"=>"form-control","id"=>"pais_estudio"]) !!}
                {!! Form::hidden("ciudad_estudio",null,["class"=>"form-control","id"=>"ciudad_estudio"]) !!}
                {!! Form::hidden("departamento_estudio",null,["class"=>"form-control","id"=>"departamento_estudio"]) !!}
                {!! Form::text("ciudad_autocomplete",$ciudad_estudio,["class"=>"form-control","id"=>"ciudad_autocomplete","placheholder"=>"Digita Cuidad"]) !!}
            </div>
        </div>
        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("ciudad_estudio",$errors) !!}</p>
    </div>

    <div class="col-sm-6 col-lg-12">
        <div class="form-group">
            <label for="fecha_finalizacion" class="col-md-4 control-label">Fecha Finalización: </label>
            <div class="col-md-6">
                {!! Form::text("fecha_finalizacion",null,["class"=>"form-control","placeholder"=>"Fecha Finalización","id"=>"fecha_finalizacion" ]) !!}


            </div>
        </div>
        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("fecha_finalizacion",$errors) !!}</p>
    </div>
    <div class="col-sm-6 col-lg-12">
        <div class="form-group">
            <label for="semestres_cursados" class="col-md-4 control-label">Semestres Cursados:<span class='text-danger sm-text-label'></span></label>
            <div class="col-md-6">
                {!! Form::select("semestres_cursados",[""=>"Seleccionar",1,2,3,4,5,6,7,9,10],null,["class"=>"form-control"]) !!}

            </div>
        </div>
        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("semestres_cursados",$errors) !!}</p>
    </div>

</div><!-- fin row -->

<div class="col-md-12 separador"></div>
<p class="direction-botones-center set-margin-top">
    @if(isset($editar))
    <button class="btn btn-danger btn-gra" type="button" id="cancelar_estudio"><i class="fa fa-floppy-o"></i>&nbsp;Cancelar</button>
    <button class="btn-quote" type="button" id="actualizar_estudio"><i class="fa fa-floppy-o"></i>&nbsp;Actualizar</button>
    @else
    <button class="btn btn-primario btn-gra" type="button" id="guardar_estudio"><i class="fa fa-floppy-o"></i>&nbsp;Guardar</button>
    @endif

</p>
{!! Form::close() !!}
<script>
    $(function () {
        $('.checkbox-preferencias').bootstrapSwitch();
        $("#fecha_finalizacion").datepicker(confDatepicker);

        $('#ciudad_autocomplete').autocomplete({
            serviceUrl: '{{ route("autocomplete_cuidades") }}',
            autoSelectFirst: true,
            onSelect: function (suggestion) {
                $("#pais_estudio").val(suggestion.cod_pais);
                $("#departamento_estudio").val(suggestion.cod_departamento);
                $("#ciudad_estudio").val(suggestion.cod_ciudad);
            }
        });
    });
</script>
