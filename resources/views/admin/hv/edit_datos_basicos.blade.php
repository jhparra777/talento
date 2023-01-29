<!-- Inicio contenido principal -->
<div class="col-right-item-container">
    <div class="container-fluid">

        {!! Form::model($datos_basicos,["class"=>"form-horizontal form-datos-basicos","id"=>"fr_datos_basicos","role"=>"form","method"=>"POST","files"=>true]) !!}
        {!! Form::hidden("user_id") !!}
        <div class="row">
            <h3 class="header-section-form">Información Personal <span class='text-danger sm-text'> Campos con asterisco(*) son obligatorios</span></h3>



            <div class="col-sm-6 col-lg-6">
                <div class="form-group">
                    <label for="numero_id" class="col-md-5 control-label">Foto:</label>
                    <div class="col-md-7">

                        {!! Form::file("foto",["class"=>"form-control", "id"=>"foto" ,"name"=>"foto" ]) !!}
                    </div>
                </div>
            </div>
            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("foto",$errors) !!}</p>
            <div class="col-sm-6 col-lg-6">
                <div class="form-group">
                    <label for="tipo_id" class="col-md-5 control-label">Tipo ID:<span class='text-danger sm-text-label'>*</span></label>
                    <div class="col-md-7">

                        {!! Form::select("tipo_id",$tipos_documentos,null,["class"=>"form-control","id"=>"tipo_id"]) !!}

                    </div>                  

                </div>
                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("tipo_id",$errors) !!}</p>
            </div>

            <div class="col-sm-6 col-lg-6">
                <div class="form-group">
                    <label for="numero_id" class="col-md-5 control-label">Número ID: <span class='text-danger sm-text-label'>*</span></label>
                    <div class="col-md-7">
                        {!! Form::text("numero_id",null,["class"=>"form-control", "id"=>"numero_id" , "placeholder"=>"Identificación"]) !!}

                    </div>

                </div>
                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("numero_id",$errors) !!}</p>
            </div>
            <div class="col-sm-6 col-lg-6">
                <div class="form-group">
                    <label for="ciudad_id" class="col-md-5 control-label">Ciudad de expedición documento:<span class='text-danger sm-text-label'>*</span></label>
                    <div class="col-md-7">
                        {!! Form::hidden("pais_id",null,["class"=>"form-control","id"=>"pais_id"]) !!}
                        {!! Form::hidden("ciudad_id",null,["class"=>"form-control","id"=>"ciudad_id"]) !!}
                        {!! Form::hidden("departamento_id",null,["class"=>"form-control","id"=>"departamento_id"]) !!}
                        {!! Form::text("ciudad_autocomplete",$txtLugarExpedicion,["class"=>"form-control","id"=>"ciudad_autocomplete","placheholder"=>"Digita cuidad"]) !!}

                    </div>
                </div>
                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("ciudad_id",$errors) !!}</p>
            </div>
            <div class="col-sm-6 col-lg-6">
                <div class="form-group">
                    <label for="fecha_expedicion" class="col-md-5 control-label">Fecha Expedición:<span class='text-danger sm-text-label'>*</span></label>
                    <div class="col-md-7">
                        {!! Form::text("fecha_expedicion",null,["class"=>"form-control", "id"=>"fecha_expedicion" ,"placeholder"=>"Fecha Expedición" ]) !!}

                    </div>
                </div>
                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("fecha_expedicion_id",$errors) !!}</p>
            </div>
            <div class="col-sm-6 col-lg-6">
                <div class="form-group">
                    <label for="nombres" class="col-md-5 control-label">Nombres:<span class='text-danger sm-text-label'>*</span></label>
                    <div class="col-md-7">

                        {!! Form::text("nombres",null,["class"=>"form-control", "id"=>"nombres", "placeholder"=>"Nombres" ]) !!}
                    </div>
                </div>
                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("nombres",$errors) !!}</p>
            </div>
            <div class="col-sm-6 col-lg-6">
                <div class="form-group">
                    <label for="primer_apellido" class="col-md-5 control-label">Primer Apellido:<span class='text-danger sm-text-label'>*</span></label>
                    <div class="col-md-7">
                        {!! Form::text("primer_apellido",null,["class"=>"form-control", "name"=>"primer_apellido" ,"id"=>"primer_apellido", "placeholder"=>"Primer Apellido"]) !!}

                    </div>
                </div>
                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("primer_apellido",$errors) !!}</p>
            </div>
            <div class="col-sm-6 col-lg-6">
                <div class="form-group">
                    <label for="segundo_apellido" class="col-md-5 control-label">Segundo Apellido:</label>
                    <div class="col-md-7">

                        {!! Form::text("segundo_apellido",null,["class"=>"form-control" ,"id"=>"segundo_apellido", "placeholder"=>"Segundo Apellido" ]) !!}
                    </div>
                </div>
                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("segundo_apellido",$errors) !!}</p>
            </div>
            <div class="col-sm-6 col-lg-6">
                <div class="form-group">
                    <label for="fecha_nacimiento" class="col-md-5 control-label">Fecha Nacimiento:<span class='text-danger sm-text-label'>*</span></label>
                    <div class="col-md-7">
                        {!! Form::text("fecha_nacimiento",null,["class"=>"form-control", "id"=>"fecha_nacimiento" , "placeholder"=>"Fecha Nacimiento"]) !!}

                    </div>
                </div>
                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("fecha_nacimiento",$errors) !!}</p>
            </div>
            <div class="col-sm-6 col-lg-6">
                <div class="form-group">
                    <label for="pais_nacimiento" class="col-md-5 control-label">Lugar Nacimiento:<span class='text-danger sm-text-label'>*</span></label>
                    <div class="col-md-7">
                        {!! Form::hidden("pais_nacimiento",null,["id"=>"pais_nacimiento"]) !!}
                        {!! Form::hidden("departamento_nacimiento",null,["id"=>"departamento_nacimiento"]) !!}
                        {!! Form::hidden("ciudad_nacimiento",null,["id"=>"ciudad_nacimiento"]) !!}
                        {!! Form::text("txt_nacimiento",$txtLugarNacimiento,["id"=>"txt_nacimiento","class"=>"form-control","placheholder"=>"Digita cuidad"]) !!}

                    </div>
                </div>
                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("ciudad_nacimiento",$errors) !!}</p>
            </div>
            <div class="col-sm-6 col-lg-6">
                <div class="form-group">
                    <label for="fecha_nacimiento" class="col-md-5 control-label">Grupo Sanguinero:<span class='text-danger sm-text-label'>*</span></label>
                    <div class="col-md-7">
                        {!! Form::select("grupo_sanguineo",[""=>"Seleccionar","A"=>"A","B"=>"B","O"=>"O","AB"=>"AB"],null,["class"=>"form-control", "id"=>"fecha_nacimiento"]) !!}

                    </div>
                </div>
                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("rh",$errors) !!}</p>
            </div>
            <div class="col-sm-6 col-lg-6">
                <div class="form-group">
                    <label for="fecha_nacimiento" class="col-md-5 control-label">RH:<span class='text-danger sm-text-label'>*</span></label>
                    <div class="col-md-7">
                        {!! Form::select("rh",[""=>"Seleccionar","positivo"=>"Positivo","negativo"=>"Negativo"],null,["class"=>"form-control", "id"=>"fecha_nacimiento"]) !!}

                    </div>
                </div>
                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("rh",$errors) !!}</p>
            </div>

            <div class="col-sm-6 col-lg-6">
                <div class="form-group">
                    <label for="genero" class="col-md-5 control-label">Género:<span class='text-danger sm-text-label'>*</span></label>

                    <div class="col-md-7">
                        {!! Form::select("genero",$genero,null,["id"=>"genero","class"=>"form-control"]) !!}
                    </div>
                </div>
                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("genero",$errors) !!}</p>
            </div>
            <div class="col-sm-6 col-lg-6">
                <div class="form-group">
                    <label for="estado_civil" class="col-md-5 control-label">Estado Civil:<span class='text-danger sm-text-label'>*</span></label>
                    <div class="col-md-7">
                        {!! Form::select("estado_civil",$estadoCivil,null,["class"=>"form-control" ,"id"=>"estado_civil"]) !!}

                    </div>
                </div>
                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("estado_civil",$errors) !!}</p>
            </div>
            <div class="col-sm-6 col-lg-6">
                <div class="form-group">
                    <label for="movil" class="col-md-5 control-label">Teléfono Móvil:</label>
                    <div class="col-md-7">
                        {!! Form::text("telefono_movil",null,["class"=>"form-control" ,"id"=>"telefono_fijo", "placeholder"=>"Móvil"]) !!}

                    </div>
                </div>
                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("telefono_fijo",$errors) !!}</p>
            </div>
            <div class="col-sm-6 col-lg-6">
                <div class="form-group">
                    <label for="telefono_fijo" class="col-md-5 control-label">Teléfono Fijo:</label>
                    <div class="col-md-7">
                        {!! Form::text("telefono_fijo",null,["class"=>"form-control" ,"id"=>"telefono_fijo" ,"placeholder"=>"Teléfono Fijo"]) !!}

                    </div>
                </div>
                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("telefono_fijo",$errors) !!}</p>
            </div>
            <div class="col-sm-6 col-lg-6">
                <div class="form-group">
                    <label for="email" class="col-md-5 control-label">Correo Electrónico:<span class='text-danger sm-text-label'>*</span></label>
                    <div class="col-md-7">                      
                        {!! Form::text("email",null,["class"=>"form-control" ,"id"=>"email" ,"placeholder"=>"Correo Electrónico"]) !!}
                    </div>
                </div>
                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("email",$errors) !!}</p>
            </div>
            <div class="col-sm-6 col-lg-6">
                <div class="form-group">
                    <label for="aspiracion_salarial" class="col-md-5 control-label">Aspiración Salarial:<span class='text-danger sm-text-label'>*</span></label>
                    <div class="col-md-7">
                        {!! Form::select("aspiracion_salarial",$aspiracionSalarial,null,["class"=>"form-control" ,"id"=>"aspiracion_salarial"]) !!}
                    </div>
                </div>
                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("aspiracion_salarial",$errors) !!}</p>
            </div>

            <div class="col-sm-6 col-lg-6">
                <div class="form-group">
                    <label for="entidad_eps" class="col-md-5 control-label">Entidad(EPS):</label>
                    <div class="col-md-7">
                        {!! Form::select("entidad_eps",$entidadesEps,NULL,["class"=>"form-control","id"=>"entidad_eps"]) !!}
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-lg-6">
                <div class="form-group">
                    <label for="entidad_eps" class="col-md-5 control-label">Entidad(CAJA COMPENSACIÓN):</label>
                    <div class="col-md-7">
                        {!! Form::select("caja_compensaciones",$caja_compensaciones,NULL,["class"=>"form-control","id"=>"caja_compensaciones"]) !!}
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-lg-6">
                <div class="form-group">
                    <label for="entidad_afp" class="col-md-5 control-label">Entidad(AFP):</label>
                    <div class="col-md-7">
                        {!! Form::select("entidad_afp",$entidadesAfp,null,["class"=>"form-control","id"=>"entidad_afp"]) !!}
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-6">
                <div class="form-group">
                    <label for="ciudad_residencia" class="col-md-5 control-label">Ciudad Residencia:<span class='text-danger sm-text-label'>*</span></label>
                    <div class="col-md-7">

                        {!! Form::hidden("pais_residencia",null,["id"=>"pais_residencia"]) !!}
                        {!! Form::hidden("departamento_residencia",null,["id"=>"departamento_residencia"]) !!}
                        {!! Form::hidden("ciudad_residencia",null,["id"=>"ciudad_residencia"]) !!}
                        {!! Form::text("txt_residencia",$txtLugarResidencia,["id"=>"txt_residencia","class"=>"form-control","placheholder"=>"Digita cuidad"]) !!}
                    </div>
                </div>
                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("ciudad_residencia",$errors) !!}</p>
            </div>

            <div class="col-sm-6 col-lg-6">
                <div class="form-group">
                    <label for="complemento" class="col-md-5 control-label">Barrio:</label>
                    <div class="col-md-7">
                        {!! Form::text("barrio",null,["class"=>"form-control","id"=>"direccion","placeholder"=>"" ]) !!}

                    </div>
                </div>
            </div>
            <div class="">
                <div class="col-sm-6 col-lg-12">
                    <div class="form-group">
                        <label for="complemento" class="col-md-3 control-label">Dirección:</label>
                        <div class="col-md-9">
                            {!! Form::text("direccion",null,["class"=>"form-control","id"=>"direccion","placeholder"=>"" ]) !!}

                        </div>
                    </div>
                </div>
            </div>

        </div><!-- fin row -->

        <div class="row" id="info-adicional">
            <h3 class="header-section-form">Información Adicional(Opcional)</h3>
            <div class="col-sm-6 col-lg-6">
                <div class="form-group">
                    <label for="situacion_militar_definida" class="col-md-7 control-label">Situación Militar Definida:</label>
                    <div class="col-md-5">
                        {!! Form::checkbox("situacion_militar_definida",1,(($datos_basicos->situacion_militar_definida == "1")?true:((Session::has("situacion_militar_definida"))?true:false)),["class"=>"checkbox-preferencias"]) !!}

                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-6">
                <div class="form-group">
                    <label for="complemento" class="col-md-5 control-label">No. Libreta:</label>
                    <div class="col-md-7">
                        {!! Form::text("numero_libreta",null,["class"=>"form-control", "id"=>"numero_libreta","placeholder"=>"# Libreta Militar"]) !!}

                    </div>
                </div>
                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("numero_libreta",$errors) !!}</p>
            </div>
            <div class="col-sm-6 col-lg-6">
                <div class="form-group">
                    <label for="tipo_via" class="col-md-5 control-label">Clase Libreta:</label>
                    <div class="col-md-7">
                        {!! Form::select("clase_libreta",$claseLibreta,null,["id"=>"clase_libreta","class"=>"form-control"]) !!}

                    </div>
                </div>
                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("clase_libreta",$errors) !!}</p>
            </div>
            <div class="col-sm-6 col-lg-6">
                <div class="form-group">
                    <label for="num_distrito_militar" class="col-md-5 control-label"># Distrito Militar:</label>
                    <div class="col-md-7">
                        {!! Form::text("distrito_militar",null,["id"=>"distrito_militar","class"=>"form-control","placeholder"=>"Número Distrito"]) !!}
                    </div>
                </div>
                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("distrito_militar",$errors) !!}</p>
            </div>
            <div class="col-sm-6 col-lg-6">
                <div class="form-group">
                    <label for="tiene_vehiculo" class="col-md-5 control-label">Tiene Vehículo:</label>
                    <div class="col-md-7">
                        {!! Form::select("tiene_vehiculo",[""=>"Seleccionar","1"=>"si","0"=>"no"],null,["class"=>"form-control","id"=>"tiene_vehiculo"]) !!}
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-6">
                <div class="form-group">
                    <label for="tipo_vehiculo" class="col-md-5 control-label">Tipo Vehículo:</label>
                    <div class="col-md-7">
                        {!! Form::select("tipo_vehiculo",$tipoVehiculo,null,["id"=>"tipo_vehiculo","class"=>"form-control"]) !!}

                    </div>
                </div>
                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("tipo_vehiculo",$errors) !!}</p>
            </div>
            <div class="col-sm-6 col-lg-6">
                <div class="form-group">
                    <label for="num_licencia" class="col-md-5 control-label"># Licencia:</label>
                    <div class="col-md-7">
                        {!! Form::text("numero_licencia",null,["class"=>"form-control", "id"=>"numero_licencia","placeholder"=>"# Licencia"]) !!}
                    </div>
                </div>
                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("numero_licencia",$errors) !!}</p>
            </div>
            <div class="col-sm-6 col-lg-6">
                <div class="form-group">
                    <label for="categoria_licencia" class="col-md-5 control-label">Categoría Licencia:</label>
                    <div class="col-md-7">
                        {!! Form::select("categoria_licencia",$categoriaLicencias,NULL,["class"=>"form-control","id"=>"categoria_licencia"])  !!}
                    </div>
                </div>
                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("categoria_licencia",$errors) !!}</p>
            </div>

        </div>
        <div class="col-md-12 separador"></div>
        <p class="direction-botones-center set-margin-top">
            <button class="btn btn-success btn-gra" type="button" id="guardar_datos_basicos_admin" ><i class="fa fa-floppy-o"></i>&nbsp;Guardar</button>
        </p>
        {!! Form::close() !!}<!-- /.fin form -->
    </div><!-- /.container -->
</div>
<!-- Fin contenido principal -->
<script>
    $(function () {

        $("#fecha_expedicion, #fecha_nacimiento").datepicker(confDatepicker);


        $('#ciudad_autocomplete').autocomplete({
            serviceUrl: '{{ route("autocomplete_cuidades") }}',
            autoSelectFirst: true,
            onSelect: function (suggestion) {
                $("#pais_id").val(suggestion.cod_pais);
                $("#departamento_id").val(suggestion.cod_departamento);
                $("#ciudad_id").val(suggestion.cod_ciudad);
            }
        });
        $('#txt_nacimiento').autocomplete({
            serviceUrl: '{{ route("autocomplete_cuidades") }}',
            autoSelectFirst: true,
            onSelect: function (suggestion) {
                $("#pais_nacimiento").val(suggestion.cod_pais);
                $("#departamento_nacimiento").val(suggestion.cod_departamento);
                $("#ciudad_nacimiento").val(suggestion.cod_ciudad);
            }
        });
        $('#txt_residencia').autocomplete({
            serviceUrl: '{{ route("autocomplete_cuidades") }}',
            autoSelectFirst: true,
            onSelect: function (suggestion) {
                $("#pais_residencia").val(suggestion.cod_pais);
                $("#departamento_residencia").val(suggestion.cod_departamento);
                $("#ciudad_residencia").val(suggestion.cod_ciudad);
            }
        });
        $(document).on("change", ".direccion", function () {
            var txtConcat = "";
            var campos = $(".direccion");
            $("#direccion").val("");
            $.each(campos, function (key, value) {
                var campos = $(value);
                var type = campos.attr("type");
                if (type == "checkbox") {
                    if (campos.prop("checked")) {
                        txtConcat += campos.val() + " ";
                    }
                } else {
                    txtConcat += campos.val() + " ";
                }

            })
            $("#direccion").val(txtConcat);
        });
        $(document).on("keyup", ".direccion_txt", function () {
            var txtConcat = "";
            var campos = $(".direccion");
            $("#direccion").val("");
            $.each(campos, function (key, value) {
                var campos = $(value);
                var type = campos.attr("type");
                if (type == "checkbox") {
                    if (campos.prop("checked")) {
                        txtConcat += campos.val() + " ";
                    }
                } else {
                    txtConcat += campos.val() + " ";
                }

            })
            $("#direccion").val(txtConcat);
        });
        $("#guardar_datos_basicos_admin").on("click", function () {
            $.ajax({
                type: "POST",
                data: $("#fr_datos_basicos").serialize(),
                url: "{{route('admin.actualizar_datos_basicos')}}",
                success: function (response) {
                    $("#container_tab").html(response.view);
                }
            });
        });
    });

</script>
