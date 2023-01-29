{!! Form::model($campos,["class"=>"form-horizontal form-datos-basicos" ,"role"=>"form","id"=>"fr_grupo"]) !!}
{!! Form::hidden("id") !!}
<div class="row">
    <h3 class="header-section-form"> <span class='text-danger sm-text'> Recuerde que los campos marcados con el símbolo (*) son obligatorios.</span></h3>
    <div class="col-md-12">
        <p class="text-primary set-general-font-bold">
            Por favor ingrese los datos de las personas que componen su núcleo familiar y luego haga clic en Guardar.
        </p>
        <p class="direction-botones-left">
            <a href="#grilla-datos" class="btn btn-defecto btn-peq"><i class="fa fa-file-text"></i>&nbsp;Mis Familiares</a>
        </p>
    </div>
 
    <div class="col-sm-6 col-lg-12">
        <div class="form-group">
            <label for="tipo_documento" class="col-md-4 control-label">Tipo Documento:<span class='text-danger sm-text-label'>*</span></label>
            <div class="col-md-6">
                {!! Form::select("tipo_documento",$selectores->tipoDocumento,null,["class"=>"form-control"])!!}
            </div>
        </div>
        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("tipo_documento",$errors) !!}</p>
    </div>
    <div class="col-sm-6 col-lg-12">
        <div class="form-group">
            <label for="documento_identidad" class="col-md-4 control-label"># Documento:<span class='text-danger sm-text-label'>*</span> </label>
            <div class="col-md-6">
                {!! Form::text("documento_identidad",null,["class"=>"form-control solo_numeros2"]) !!}
            </div>
        </div>
        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("documento_identidad",$errors) !!}</p>
    </div>
    <div class="col-sm-6 col-lg-12">
        <div class="form-group">
            <label for="nombres" class="col-md-4 control-label">Nombres:<span class='text-danger sm-text-label'>*</span> </label>
            <div class="col-md-6">
                {!! Form::text("nombres",null,["class"=>"form-control","placeholder"=>"Nombres" ]) !!}

            </div>
        </div>
        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("nombres",$errors) !!}</p>
    </div>
    <div class="col-sm-6 col-lg-12">
        <div class="form-group">
            <label for="ref_apellido1" class="col-md-4 control-label">Primer Apellido:<span class='text-danger sm-text-label'>*</span> </label>
            <div class="col-md-6">
                {!! Form::text("primer_apellido",null,["class"=>"form-control","placeholder"=>"Primer Apellido" ]) !!}
            </div>
        </div>
        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("primer_apellido",$errors) !!}</p>
    </div>
    <div class="col-sm-6 col-lg-12">
        <div class="form-group">
            <label for="ref_apellido2" class="col-md-4 control-label">Segundo Apellido:<span class='text-danger sm-text-label'></span> </label>
            <div class="col-md-6">
                {!! Form::text("segundo_apellido",null,["class"=>"form-control","placeholder"=>"Segundo Apellido" ]) !!}
            </div>
        </div>
        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("segundo_apellido",$errors) !!}</p>
    </div>
    <div class="col-sm-6 col-lg-12">
        <div class="form-group">
            <label for="escolaridad" class="col-md-4 control-label">Nivel Estudio:<span class='text-danger sm-text-label'></span></label>
            <div class="col-md-6">
                {!!  Form::select("escolaridad_id",$selectores->escolaridad,null,["class"=>"form-control"]) !!}

            </div>
        </div>
        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("escolaridad_id",$errors) !!}</p>
    </div>
    <div class="col-sm-6 col-lg-12">
        <div class="form-group">
            <label for="parentesco" class="col-md-4 control-label">Parentesco:<span class='text-danger sm-text-label'>*</span></label>
            <div class="col-md-6">
                {!!  Form::select("parentesco_id",$selectores->parentesco,null,["class"=>"form-control"]) !!}
            </div>
        </div>
        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("parentesco_id",$errors) !!}</p>
    </div>
    <div class="col-sm-6 col-lg-12">
        <div class="form-group">
            <label for="genero" class="col-md-4 control-label">Género:<span class='text-danger sm-text-label'>*</span></label>
            <div class="col-md-6">
                {!! Form::select("genero",$selectores->genero,null,["class"=>"form-control"]) !!}

            </div>
        </div>
        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("genero",$errors) !!}</p>
    </div>
    <div class="col-sm-6 col-lg-12">
        <div class="form-group">
            <label for="fecha_nacimiento" class="col-md-4 control-label">Fecha Nacimiento:<span class='text-danger sm-text-label'>*</span> </label>
            <div class="col-md-6">

                {!! Form::text("fecha_nacimiento",null,["class"=>"form-control" ,"id"=>"fecha_nacimiento", "placeholder"=>"Fecha Nacimiento" ]) !!}
            </div>
        </div>
        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("fecha_nacimiento",$errors) !!}</p>
    </div>
    <div class="col-sm-6 col-lg-12">
        <div class="form-group">
            <label for="ciudad_nacimiento" class="col-md-4 control-label">Ciudad Nacimiento:<span class='text-danger sm-text-label'>*</span> </label>
            <div class="col-md-6">
                {!! Form::hidden("codigo_pais_nacimiento",null,["class"=>"form-control","id"=>"pais_id2"]) !!}
                {!! Form::hidden("codigo_ciudad_nacimiento",null,["class"=>"form-control","id"=>"ciudad_id2"]) !!}
                {!! Form::hidden("codigo_departamento_nacimiento",null,["class"=>"form-control","id"=>"departamento_id2"]) !!}
                {!! Form::text("ciudad_autocomplete2",null,["class"=>"form-control","id"=>"ciudad_autocomplete2","placeholder"=>"Digita cuidad"]) !!}

            </div>
        </div>
        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("codigo_ciudad_nacimiento",$errors) !!}</p>
    </div>
    <div class="col-sm-6 col-lg-12">
        <div class="form-group">
            <label for="profesion" class="col-md-4 control-label">Profesión:<span class='text-danger sm-text-label'></span></label>
            <div class="col-md-6">
                {!! Form::hidden("profesion_id",null,["class"=>"form-control","id"=>"profesion_id"]) !!}
                {!! Form::text("cargo_desempenado_autocomplete",null,["class"=>"form-control","id"=>"cargo_desempenado_autocomplete"]) !!}

            </div>
        </div>
        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("profesion_id",$errors) !!}</p>
    </div>
</div><!-- fin row -->

<div class="col-md-12 separador"></div>
<p class="direction-botones-center set-margin-top">
    @if(isset($editar))
    <button class="btn btn-danger btn-gra" type="button" id="cancelar_familiar" ><i class="fa fa-floppy-o"></i>&nbsp;Cancelar</button>
    <button class="btn-quote" type="button" id="actualizar_familiar" ><i class="fa fa-floppy-o"></i>&nbsp;Actualizar</button>
    @else
    <button class="btn btn-primario btn-gra" type="button" id="guardar_grupo" ><i class="fa fa-floppy-o"></i>&nbsp;Guardar</button>
    @endif
</p>
{!! Form::close() !!}<!-- /.fin form -->
<script>
    $(function () {
        /* auto complete profesion */
        $('#cargo_desempenado_autocomplete').autocomplete({
            serviceUrl: '{{ route("autocomplete_cargo_desempenado") }}',
            autoSelectFirst: true,
            onSelect: function (suggestion) {
                $("#profesion_id").val(suggestion.id);
            }
        });
        /* fin auto complete profesion */
        $("#fecha_nacimiento").datepicker(confDatepicker);
        $('#ciudad_autocomplete').autocomplete({
            serviceUrl: '{{ route("autocomplete_cuidades") }}',
            autoSelectFirst: true,
            onSelect: function (suggestion) {
                $("#pais_id").val(suggestion.cod_pais);
                $("#departamento_id").val(suggestion.cod_departamento);
                $("#ciudad_id").val(suggestion.cod_ciudad);
            }
        });
        $('#ciudad_autocomplete2').autocomplete({
            serviceUrl: '{{ route("autocomplete_cuidades") }}',
            autoSelectFirst: true,
            onSelect: function (suggestion) {
                $("#pais_id2").val(suggestion.cod_pais);
                $("#departamento_id2").val(suggestion.cod_departamento);
                $("#ciudad_id2").val(suggestion.cod_ciudad);
            }
        });
    });

</script>