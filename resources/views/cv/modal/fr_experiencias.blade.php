{!! Form::model($experiencia,["class"=>"form-horizontal form-datos-basicos", "role"=>"form", "id"=>"fr_experiencias"]) !!}
{!! Form::hidden("id") !!}
<div class="row">
    <h3 class="header-section-form"> <span class='text-danger sm-text'> Recuerde que los campos marcados con el símbolo (*) son obligatorios.</span></h3>
    <div class="col-md-12">
        <p class="text-primary set-general-font-bold">
            Por favor ingrese los datos de sus empleos anteriores, le recomendamos que registre desde su empleo más antiguo al más reciente y luego haga clic en Guardar
        </p>
        <p class="direction-botones-left">
            <a href="#grilla" class="btn btn-defecto btn-peq"><i class="fa fa-file-text"></i>&nbsp;Mis Experiencias</a>
        </p>
    </div>

    <div class="col-sm-6 col-lg-6">
        <div class="form-group">
            <label for="numero_id" class="col-md-5 control-label">Nombre Empresa:<span class='text-danger sm-text-label'>*</span> </label>
            <div class="col-md-7">
                {!! Form::text("nombre_empresa",null,["class"=>"form-control","placeholder"=>"Nombre Empresa"]) !!}

            </div>
            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("nombre_empresa",$errors) !!}</p>
        </div>
    </div>
    <div class="col-sm-6 col-lg-6">
        <div class="form-group">
            <label for="numero_id" class="col-md-5 control-label">Teléfono Empresa: </label>
            <div class="col-md-7">
                {!! Form::text("telefono_temporal",null,["class"=>"form-control"]) !!}
            </div>
        </div>
        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("telefono_temporal",$errors) !!}</p>
    </div>

    <div class="col-sm-6 col-lg-6">
        <div class="form-group">
            <label for="ciudad" class="col-md-5 control-label">Ciudad:<span class='text-danger sm-text-label'>*</span> </label>
            <div class="col-md-7">
                {!! Form::hidden("pais_id",null,["class"=>"form-control","id"=>"pais_id"]) !!}
                {!! Form::hidden("ciudad_id",null,["class"=>"form-control","id"=>"ciudad_id"]) !!}
                {!! Form::hidden("departamento_id",null,["class"=>"form-control","id"=>"departamento_id"]) !!}
                {!! Form::text("ciudad_autocomplete",$txtCiudad ,["class"=>"form-control","id"=>"ciudad_autocomplete","placheholder"=>"Digita cuidad"]) !!}
            </div>
            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("ciudad_id",$errors) !!}</p>
        </div>
    </div>
    <div class="col-sm-6 col-lg-6">
        <div class="form-group">
            <label for="cargo_especifico" class="col-md-5 control-label">Cargo Desempeñado:<span class='text-danger sm-text-label'>*</span></label>
            <div class="col-md-7">
                {!! Form::text("cargo_especifico",null,["class"=>"form-control","id"=>"cargo_especifico","placeholder"=>"Cargo Desempeñado"]) !!}

            </div>
        </div>
        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("cargo_especifico",$errors) !!}</p>
    </div>
    <div class="col-sm-6 col-lg-6">
        <div class="form-group">
            <label for="tipo_id" class="col-md-5 control-label">Cargo Similar:<span class='text-danger sm-text-label'>*</span></label>
            <div class="col-md-7">
            <!-- 
                Form::hidden("cargo_desempenado",$experiencia->cargo_desempenado,["class"=>"form-control","id"=>"cargo_desempenado"]) !!}
                {!! Form::text("cargo_desempenado_autocomplete",$txtProfesion,["class"=>"form-control","id"=>"cargo_desempenado_autocomplete"]) !!}
            -->
            {!! Form::select("cargo_desempenado",$cargoGenerico,null,["class"=>"form-control" ,"id"=>"Cargo"]) !!}
            </div>
        </div>
        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("cargo_desempenado",$errors) !!}</p>
    </div>
    <div class="col-sm-6 col-lg-6">
        <div class="form-group">
            <label for="nombres_jefe" class="col-md-5 control-label">Nombres Jefe:<span class='text-danger sm-text-label'>*</span> </label>
            <div class="col-md-7">
                {!! Form::text("nombres_jefe",null,["class"=>"form-control", "id"=>"nombres_jefe","placeholder"=>"Nombres Jefe Inmediato"]) !!}

            </div>
        </div>
        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("nombres_jefe",$errors) !!}</p>
    </div>
    <div class="col-sm-6 col-lg-6">
        <div class="form-group">
            <label for="cargo_jefe" class="col-md-5 control-label">Cargo Jefe:<span class='text-danger sm-text-label'>*</span> </label>
            <div class="col-md-7">
                {!! Form::text("cargo_jefe",null,["class"=>"form-control","id"=>"cargo_jefe", "placeholder"=>"Cargo Jefe Inmediato" ]) !!}

            </div>
        </div>
        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("cargo_jefe",$errors) !!}</p>
    </div>
    <div class="col-sm-6 col-lg-6">
        <div class="form-group">
            <label for="telefono_movil_jefe" class="col-md-5 control-label">Teléfono móvil jefe:<span class='text-danger sm-text-label'>*</span> </label>
            <div class="col-md-7">
                {!! Form::text("movil_jefe",null,["class"=>"form-control", "placeholder"=>"Movil Jefe Inmediato","id"=>"movil_jefe"]) !!}

            </div>
        </div>
        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("movil_jefe",$errors) !!}</p>
    </div>
    <div class="col-sm-6 col-lg-6">
        <div class="form-group">
            <label for="telefono_jefe" class="col-md-5 control-label">Teléfono Fijo Jefe:<span class='text-danger sm-text-label'>*</span> </label>
            <div class="col-md-4">
                {!! Form::text("fijo_jefe",null,["class"=>"form-control", "id"=>"fijo_jefe", "placeholder"=>"Teléfono Jefe Inmediato"]) !!}

            </div>
            <div class="col-md-3">
                {!! Form::text("ext_jefe",null,["class"=>"form-control", "id"=>"ext_jefe", "placeholder"=>"Extension Fijo"]) !!}

            </div>
        </div>
        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("fijo_jefe",$errors) !!}</p>
    </div>
    <div class="col-sm-6 col-lg-6">
        <div class="form-group">
            <label for="fecha_inicio" class="col-md-5 control-label">F. Inicio:<span class='text-danger sm-text-label'>*</span> </label>
            <div class="col-md-7">
                {!! Form::text("fecha_inicio",null,["class"=>"form-control", "id"=>"fecha_inicio" ,"placeholder"=>"Fecha Inicio"]) !!}

            </div>
        </div>
        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("fecha_inicio",$errors) !!}</p>
    </div>
    <div class="col-sm-6 col-lg-6">
        <div class="form-group">
            <label for="fecha_terminacion" class="col-md-5 control-label">F. Terminación:<span class='text-danger sm-text-label'>*</span> </label>
            <div class="col-md-7">
                {!! Form::text("fecha_final",(($experiencia->fecha_final=="0000-00-00")?"":$experiencia->fecha_final),["class"=>"form-control", "id"=>"fecha_terminacion" ,"placeholder"=>"Fecha Terminación"]) !!}
            </div>
        </div>
        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("fecha_final",$errors) !!}</p>
    </div>
    <div class="col-sm-6 col-lg-6">
        <div class="form-group">
            <label for="salario_devengado" class="col-md-5 control-label">Salario Devengado:<span class='text-danger sm-text-label'>*</span> </label>
            <div class="col-md-7">
                {!! Form::select("salario_devengado",$aspiracionSalarial,null,["class"=>"form-control" ,"id"=>"salario_devengado"]) !!}
            </div>
        </div>
        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("salario_devengado",$errors) !!}</p>
    </div>
    <div class="col-sm-6 col-lg-6">
        <div class="form-group">
            <label for="motivo_retiro" class="col-md-5 control-label">Motivo Retiro:<span class='text-danger sm-text-label'>*</span></label>
            <div class="col-md-7">
                {!! Form::select("motivo_retiro",$motivos,null,["class"=>"form-control","id"=>"motivo_retiro"]) !!}
            </div>
        </div>
        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("motivo_retiro",$errors) !!}</p>
    </div>
    <div class="col-sm-6 col-lg-6">
        <div class="form-group">
            <label for="trabajo-empresa-temporal" class="col-md-5 control-label">Trabajo Actual:</label>
            <div class="col-md-7">
                {!! Form::checkbox("empleo_actual",1,null,["class"=>"checkbox-preferencias" ]) !!}

            </div>
        </div>
        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("empleo_actual",$errors) !!}</p>
    </div>
    <div class="col-sm-6 col-lg-12">
        <div class="form-group">
            <label for="funcionesylogros" class="col-md-3 control-label">Funciones y Logros: <span class='text-danger sm-text-label'></span></label>
            <div class="col-md-9">
                {!! Form::textarea("funciones_logros",null,["class"=>"form-control", "rows"=>"3",  "id"=>"funcionesylogros"]) !!}

            </div>
            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("funciones_logros",$errors) !!}</p>
        </div>
    </div>
    <div class="col-sm-6 col-lg-6">
        <div class="form-group">
            
            <div class="col-md-3">
                {!! Form::hidden("autoriza_solicitar_referencias",1,null,["class"=>"checkbox-preferencias" ,"data-state"=>"false" , "id"=>"autorizo_referencia"]) !!}

            </div>
        </div>
        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("autoriza_solicitar_referencias",$errors) !!}</p>
    </div>

</div><!-- fin row -->

<div class="col-md-12 separador"></div>
<p class="direction-botones-center set-margin-top">
    @if(isset($editar))
    <button class="btn btn-danger btn-gra" type="button" id="btn_cancelar_experiencia" ><i class="fa fa-floppy-o"></i>&nbsp;Cancelar</button>
    <button class="btn-quote" type="button" id="btn_experiencias_actualizar"  ><i class="fa fa-floppy-o"></i>&nbsp;Actualizar</button>
    @else
    <button class="btn-quote" type="button" id="btn_experiencias" ><i class="fa fa-floppy-o"></i>&nbsp;Guardar</button>
    @endif

</p>
{!! Form::close() !!}
<script>
    $(function () {
        
        var confDatepicker = {
            altFormat: "yy-mm-dd",
            dateFormat: "yy-mm-dd",
            changeMonth: true,
            changeYear: true,
            buttonImage: "img/gifs/018.gif",
            buttonImageOnly: true,
            autoSize: true,
            dayNames: ["Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado"],
            monthNamesShort: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
            dayNamesMin: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],
            yearRange: "1930:2050"
        };
        /* auto complete cargo desempeñado */
        $('#cargo_desempenado_autocomplete').autocomplete({
            serviceUrl: '{{ route("autocomplete_cargo_desempenado") }}',
            autoSelectFirst: true,
            onSelect: function (suggestion) {
                $("#cargo_desempenado").val(suggestion.id);
            }
        });
        $('.checkbox-preferencias').bootstrapSwitch();
        $("#fecha_inicio, #fecha_terminacion").datepicker(confDatepicker);
        //rangoCalendarios("fecha_inicio","fecha_terminacion");
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