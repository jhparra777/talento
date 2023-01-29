{!! Form::model($campos,["class"=>"form-horizontal form-datos-basicos" ,"role"=>"form","id"=>"fr_referencias_personales"]) !!}
{!! Form::hidden("id") !!}
<div class="row">
    <h3 class="header-section-form"> <span class='text-danger sm-text'> Recuerde que los campos marcados con el símbolo (*) son obligatorios.</span></h3>
    <div class="col-md-12">
        <p class="text-primary set-general-font-bold">
            Por favor ingrese los datos de las personas que se contactarán para el proceso de referenciación personal y luego haga clic en Guardar.
        </p>
        <p class="direction-botones-left">
            <a href="#grilla-datos" class="btn btn-defecto btn-peq"><i class="fa fa-file-text"></i>&nbsp;Mis Referencias</a>
        </p>
    </div>

    <div class="col-sm-6 col-lg-12">
        <div class="form-group">
            <label for="ref_nombres" class="col-md-4 control-label">Nombres:<span class='text-danger sm-text-label'>*</span> </label>
            <div class="col-md-6">

                {!! Form::text("nombres",null,["class"=>"form-control","placeholder"=>"Nombres"]) !!}
            </div>
        </div>
        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("nombres",$errors) !!}</p>
    </div>
    <div class="col-sm-6 col-lg-12">
        <div class="form-group">
            <label for="ref_apellido1" class="col-md-4 control-label">Primer Apellido:<span class='text-danger sm-text-label'>*</span> </label>
            <div class="col-md-6">
                {!! Form::text("primer_apellido",null,["class"=>"form-control" , "placeholder"=>"Primer Apellido" ]) !!}

            </div>
        </div>
        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("primer_apellido",$errors) !!}</p>
    </div>
    <div class="col-sm-6 col-lg-12">
        <div class="form-group">
            <label for="ref_apellido2" class="col-md-4 control-label">Segundo Apellido:<span class='text-danger sm-text-label'>*</span> </label>
            <div class="col-md-6">
                {!! Form::text("segundo_apellido",null,["class"=>"form-control" ,"placeholder"=>"Segundo Apellido"]) !!}

            </div>
        </div>
        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("segundo_apellido",$errors) !!}</p>
    </div>
    <div class="col-sm-6 col-lg-12">
        <div class="form-group">
            <label for="tipo_relacion" class="col-md-4 control-label">Tipo relación:<span class='text-danger sm-text-label'>*</span></label>
            <div class="col-md-6">
                {!! Form::select("tipo_relacion_id",$tipoRelaciones,null,["class"=>"form-control" ,"id"=>"tipo_relacion"]) !!}
            </div>
        </div>
        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("tipo_relacion_id",$errors) !!}</p>
    </div>
    <div class="col-sm-6 col-lg-12">
        <div class="form-group">
            <label for="telefono_movil" class="col-md-4 control-label">Teléfono Móvil:<span class='text-danger sm-text-label'>*</span> </label>
            <div class="col-md-6">

                {!! Form::text("telefono_movil",null,["class"=>"form-control" , "placeholder"=>"Teléfono Móvil" ]) !!}
            </div>
        </div>
        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("telefono_movil",$errors) !!}</p>
    </div>
    <div class="col-sm-6 col-lg-12">
        <div class="form-group">
            <label for="telefono_fijo" class="col-md-4 control-label">Teléfono Fijo:<span class='text-danger sm-text-label'></span> </label>
            <div class="col-md-6">
                {!! Form::text("telefono_fijo",null,["class"=>"form-control", "placeholder"=>"Teléfono Fijo" ]) !!}

            </div>
        </div>
        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("telefono_fijo",$errors) !!}</p>
    </div>
    <div class="col-sm-6 col-lg-12">
        <div class="form-group">
            <label for="ref_ciudad" class="col-md-4 control-label">Ciudad:<span class='text-danger sm-text-label'>*</span> </label>
            <div class="col-md-6">
                {!! Form::hidden("codigo_pais",null,["class"=>"form-control","id"=>"pais_id"]) !!}
                {!! Form::hidden("codigo_ciudad",null,["class"=>"form-control","id"=>"ciudad_id"]) !!}
                {!! Form::hidden("codigo_departamento",null,["class"=>"form-control","id"=>"departamento_id"]) !!}
                {!! Form::text("ciudad_autocomplete",null,["class"=>"form-control","id"=>"ciudad_autocomplete","placheholder"=>"Digita cuidad"]) !!}

            </div>
        </div>
        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("codigo_ciudad",$errors) !!}</p>
    </div>
    <div class="col-sm-6 col-lg-12">
        <div class="form-group">
            <label for="ocupacion" class="col-md-4 control-label">Ocupación:<span class='text-danger sm-text-label'>*</span> </label>
            <div class="col-md-6">
                {!! Form::select("ocupacion",[""=>"Seleccionar","empleado"=>"Empleado","independiente"=>"Independiente","desempleado"=>"Desempleado","estudiante"=>"Estudiante"],null,["class"=>"form-control" ]) !!}

            </div>
        </div>
        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("ocupacion",$errors) !!}</p>
    </div>
</div><!-- fin row -->

<div class="col-md-12 separador"></div>
<p class="direction-botones-center set-margin-top">
    @if(isset($editar))
    <button class="btn btn-danger btn-gra" type="button" id="cancelar_referencia" ><i class="fa fa-floppy-o"></i>&nbsp;Cancelar</button>
    <button class="btn-quote" type="button" id="actualizar_referencia" ><i class="fa fa-floppy-o"></i>&nbsp;Actualizar</button>
    @else
    <button class="btn btn-primario btn-gra" type="button" id="guardar_referencia" ><i class="fa fa-floppy-o"></i>&nbsp;Guardar</button>
    @endif
</p>
{!!  Form::close() !!}<!-- /.fin form -->
<script>
    $(function () {
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