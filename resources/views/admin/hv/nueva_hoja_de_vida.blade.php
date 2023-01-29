@extends("admin.layout.master")
@section("contenedor")
    
<div class="row">
    <div class="col-md-12">
        <h2>Nueva hoja de vida</h2>
        <br>
    </div>
</div>

{!! Form::open([
    "class" => "form-datos-basicos", 
    "id" => "fr_datos_basicos", 
    "role" => "form", 
    "route" => "guardar_datos_basicos_admin", 
    "method" => "POST", 
    "enctype" => "multipart/form-data", 
    "data-smk-icon" => "glyphicon glyphicon-remove"
]) !!}
    {{-- Información personal --}}
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="col-md-12">
                        <h3>Información Personal <small class='text-danger'>Los campos con asterisco (*) son obligatorios.</small></h3>
                        <br>
                    </div>

                    {{ csrf_field() }}

                    {{-- Cédula de identidad --}}
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="numero_id">
                                @if(route('home') == "https://gpc.t3rsc.co")
                                    Cédula de identidad 
                                @else
                                    Número de identificación 
                                @endif: <span class='text-danger'>*</span>
                            </label>
                            {!! Form::number("numero_id", null, [
                                "class" => "form-control input-number", 
                                "id" => "numero_id", 
                                "placeholder" => "Identificación", 
                                "maxlength" => "16", 
                                "pattern" => ".{1,16}", 
                                'oncopy' => "return false", 
                                'onpaste' => "return false",
                                "required" => "required"
                            ]) !!}
                        </div>

                        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("numero_id", $errors) !!}</p>
                    </div>

                    {{-- Confirmar cédula de identidad --}}
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="c-numero_id">
                                Confirmar 
                                @if(route('home') == "https://gpc.t3rsc.co") 
                                    cédula de identidad 
                                @else 
                                    número de identificación 
                                @endif: <span class='text-danger'>*</span>
                            </label>
                            {!! Form::number("c-numero_id", null, [
                                "class" => "form-control input-number",
                                "id" => "c-numero_id" ,
                                "placeholder" => "Identificación",
                                "maxlength" => "16",
                                "pattern" => ".{1,16}", 
                                "oncopy" => "return false", 
                                'onpaste' => "return false",
                                "required" => "required"
                            ]) !!}
                        </div>

                        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("c-numero_id", $errors) !!}</p>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="primer_apellido">Primer nombre: <span class='text-danger'>*</span></label>
                            {!! Form::text("primer_nombre", null, [
                                "class" => "form-control",
                                "name" => "primer_nombre",
                                "id" => "primer_nombre", 
                                "placeholder" => "Primer nombre",
                                "required" => "required"
                            ]) !!}
                        </div>

                        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("primer_nombre", $errors) !!}</p>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="primer_apellido">Segundo nombre: <span class='text-danger'></span></label>
                            {!! Form::text("segundo_nombre", null, [
                                "class" => "form-control",
                                "name" => "segundo_nombre",
                                "id" => "segundo_nombre", 
                                "placeholder" => "Segundo nombre"
                            ]) !!}
                        </div>

                        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("segundo_nombre", $errors) !!}</p>
                    </div>

                    {{-- Primer apellido --}}
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="primer_apellido">Primer apellido: <span class='text-danger'>*</span></label>
                            {!! Form::text("primer_apellido", null, [
                                "class" => "form-control",
                                "name" => "primer_apellido",
                                "id" => "primer_apellido", 
                                "placeholder" => "Primer apellido",
                                "required" => "required"
                            ]) !!}
                        </div>

                        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("primer_apellido", $errors) !!}</p>
                    </div>

                    {{-- Segundo apellido --}}
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="segundo_apellido">
                                Segundo apellido: @if(route('home') == "https://komatsu.t3rsc.co")<span class="text-danger">*</span>@endif
                            </label>
                            {!! Form::text("segundo_apellido", null, ["class" => "form-control" ,"id" => "segundo_apellido", "placeholder" => "Segundo apellido"]) !!}
                        </div>

                        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("segundo_apellido", $errors) !!}</p>
                    </div>

                    {{-- Teléfono fijo --}}
                    <div class="col-md-6">
                            <div class="form-group">
                                <label for="telefono_fijo">
                                    @if(route("home") == "https://humannet.t3rsc.co")
                                        Red fija 
                                    @else 
                                        Teléfono fijo 
                                    @endif: 
                                </label>
                                {!! Form::number("telefono_fijo", null, [
                                    "class" => "form-control input-number",
                                    "id" => "telefono_fijo",
                                    "maxlength" => "7",
                                    "min" => "1",
                                    "max" => "9999999",
                                    "pattern" => ".{1,7}",
                                    "placeholder" => "Teléfono fijo"
                                ]) !!}
                            </div>

                            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("telefono_fijo", $errors) !!}</p>
                        </div>

                    {{-- Teléfono móvil --}}
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="movil">Teléfono móvil: <span class="text-danger">*</span></label>
                            {!! Form::number("telefono_movil", null, [
                                "class" => "form-control input-number",
                                "id" => "telefono_fijo",
                                "maxlength" => "10",
                                "min" => "1",
                                "max" => "9999999999",
                                "pattern" => ".{1,10}",
                                "placeholder" => "Teléfono móvil",
                                "required" => "required"
                            ]) !!}

                            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("telefono_movil", $errors) !!}</p>
                        </div>
                    </div>

                    {{-- Correo electrónico --}}
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email">Correo electrónico: <span class='text-danger'>*</span></label>
                            {!! Form::email("email", null, ["class" => "form-control" ,"id" => "email" ,"placeholder" => "Correo electrónico", "required" => "required"]) !!}
                        </div>

                        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("email", $errors) !!}</p>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 text-right">
            <button type="submit" class="btn btn-success guardarDatosBasicos" id="guardarDatosBasicos">Guardar</button>
        </div>
    </div>
{!! Form::close() !!}

<div class="modal fade" id="myModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">CONSENTIMIENTO (POLÍTICA) DE CONFLICTO DE INTERESES</h4>
            </div>

            <div class="modal-body" style="height: 400px; overflow: auto;">
                <div id="texto" style="padding:10px; text-align: justify; margin: 10px; font-family: arial;">
                    @if(route("home") == "https://komatsu.t3rsc.co")
                        tiene el candidato algún tipo de relación de parentesco -civil, afinidad o consanguinidad- con algún empleado o contratista, proveedor, cliente de la compañía; participación en la propiedad o gestión de un tercero como lo indica la Política de Conflicto de Intereses de Komatsu Colombia S.A.S., la cual puede ser consultada en el sitio web www.komatsu.com.co”.
                        <br>
                    @else
                        Por medio del presente documento otorgo mi consentimiento previo, expreso, e informado a T3RS S.A.S. Por medio del presente documento otorgo mi consentimiento previo, expreso, e informado a T3RS S.A.S., filiales y subordinadas, en caso de tenerlas, para recolectar, almacenar, administrar, procesar, transferir, transmitir y/o utilizar (el “Tratamiento”) (i) toda información relacionada o que pueda asociarse a mí (los “Datos Personales”), y que le he revelado a la Compañía ahora o en el pasado, para ser utilizada bajo las finalidades consignadas en este documento, y (ii) aquella información de carácter sensible, entendida como información cuyo tratamiento pueda afectar mi intimidad o generar discriminación, como lo es, entre otra, información relacionada a salud o a los datos biométricos (los “Datos Sensibles”), para ser utilizada bajo las finalidades consignadas en este documento.
                        <br/><br/>
                        Declaro que he sido informado que el Tratamiento de mis Datos Personales y Datos Sensibles se ajustará a la Política de Tratamiento de la Información de T3RS, filiales y subordinadas. (La “Política”), a la cual tengo acceso, conozco y sé que puede ser consultada. Reconozco que, de conformidad con la Ley 1581 de 2012, el Decreto 1377 de 2013 y las demás normas que las modifiquen o deroguen (la “Ley”), mis Datos Personales y Datos Sensibles se almacenarán en las bases de datos administradas por la Compañía, y podrán ser utilizados, transferidos, transmitidos y administrados por ésta, según las finalidades autorizadas, sin requerir de una autorización posterior por parte mía.
                        <br/><br/>
                        Datos Sensibles. Declaro que he sido informado que mi consentimiento para autorizar el Tratamiento de mis Datos Sensibles, que hayan sido recolectado o sean recolectados por medio de esta autorización, es completamente opcional, a menos que exista un deber legal que me exija revelarlos o sea necesario revelarlos para salvaguardar mi interés vital y me encuentre en incapacidad física, jurídica y/o psicológica para hacerlo. He sido informado de cuáles son los Datos Sensibles que la Compañía tratará y he dado mi autorización para ello conforme a la Ley.
                        <br/><br/>
                        Alcance de la autorización. Declaro que la extensión temporal de esta autorización y el alcance de la misma no se limitan a los Datos Personales y/o Datos Sensibles recolectados en esta oportunidad, sino, en general, a todos los Datos Personales y/o Datos Sensibles que fueron recolectados antes de la presente autorización cuando la Ley no exigía la autorización. Este documento ratifica mi autorización retrospectiva del Tratamiento de mis Datos Personales y/o Datos Sensibles.
                        <br/><br/>
                        FFinalidades. Autorizo para que la Compañía realice el Tratamiento de los Datos Personales y Datos Sensibles para el cumplimiento de todas, o algunas de las siguientes finalidades: 
                        <br/><br/>
                        a. De licenciamiento de software o prestación de servicios de reclutamiento. <br/><br/>
                        b. Enviar notificaciones de actualización de información. <br/><br/>
                        c. Mensajes de agradecimiento y felicitaciones.<br/><br/>
                        d. Gestionar toda la Información necesaria para el cumplimiento de las obligaciones contractuales y legales de la Compañía.<br/><br/>
                        e. El proceso de archivo, de actualización de los sistemas, de protección y custodia de información y Bases de Datos de la Compañía.<br/><br/>
                        i. Procesos al interior de la Compañía, con fines de desarrollo u operativo y/o de administración de sistemas. <br/><br/>
                        j. Permitir el acceso a los Datos Personales a entidades afiliadas a la Compañía y/o vinculadas contractualmente para la prestación de servicios de consultoría en talento humano, bajo los estándares de seguridad y confidencialidad exigidos por la normativa. <br/><br/>
                        k. La transmisión de Datos Personales a terceros en Colombia y/o en el extranjero, incluso en países que no proporcionen medidas adecuadas de protección de Datos Personales, con los cuales se hayan celebrado contratos con este objeto, para fines comerciales, administrativos y/u operativos.<br/><br/>
                        l. Mantener y procesar por computadora u otros medios, cualquier tipo de Información relacionada con el perfil de los candidatos con el fin de análisis sus competencias,  habilidades y conocimiento. <br/><br/>
                        m. Las demás finalidades que determinen los responsables del Tratamiento en procesos de obtención de Datos Personales para su Tratamiento, con el fin de dar cumplimiento a las obligaciones legales y regulatorias, así como de las políticas de la Compañía.<br/><br/>
                        <br/><br/>
                        Datos del responsable del Tratamiento. Declaro que he sido informado de los datos del responsable del Tratamiento de los Datos Personales y Datos Sensibles, los cuales son: 
                        <br/><br/>
                        El área responsable es Tecnología de T3RS administracion@t3rsc.co.<br/><br/>

                        Derechos. Declaro que he sido informado de los derechos de habeas data que me asisten como titular de los Datos Personales y Datos Sensibles, particularmente, los derechos a conocer, actualizar, rectificar, suprimir los Datos Personales o revocar la autorización aquí otorgada, en los términos y bajo el procedimiento consagrado en la Política. Igualmente, declaro que puedo solicitar prueba de la autorización otorgada a la Compañía. He sido informado de los otros derechos que la Política me concede como Titular y soy consciente de los alcances jurídicos de esta autorización.
                        <br/><br/>
                        Transmisión o transferencia. He sido informado y autorizo a la Compañía a transmitir o transferir, según sea el caso, mis Datos Personales a terceros, dentro o fuera del territorio colombiano, para los procesos de licenciamiento de software y/o reclutamiento de personal para distintas compañías. Todos los Datos Personales que yo entregue a la Compañía o que hayan sido recibidos por la Compañía por terceros, entran dentro de esta autorización para ser transmitidos o transferidos si es requerido para el cumplimiento cabal de las finalidades aquí descritas. 
                        <br/><br/>
                        Autorización de terceros. Declaro que he obtenido la autorización de terceros que han sido incluidos en mis datos personales o de referencia y que he obtenido de ellos la autorización para que la Compañía los contacte, en caso de ser necesario, para verificar los Datos Personales que yo he entregado a la Compañía.
                        <br/><br/>
                        Duración. La Compañía podrá realizar el Tratamiento de mis Datos Personales por todo el tiempo que sea necesario para cumplir con las finalidades descritas en este documento y para que pueda prestar sus servicios licenciamiento de software y/o reclutamiento de personal para distintas compañías.
                        <br/><br/>
                    @endif
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-xs col-md-2 pull-right" data-dismiss="modal">Cerrar</button>  
            </div>
        </div>
    </div>
</div>

<script>
    $(function () {
        $("#fecha_expedicion, #fecha_nacimiento").datepicker(confDatepicker);

        var countries = [
            {value: 'Andorra', data: 'AD'},
            // ...
            {value: 'Zimbabwe', data: 'ZZ'}
        ];

        $('#ciudad_autocomplete_nac').autocomplete({
            serviceUrl: '{{ route("autocomplete_cuidades") }}',
            autoSelectFirst: true,
            onSelect: function (suggestion) {
                $("#pais_id_nac").val(suggestion.cod_pais);
                $("#departamento_id_nac").val(suggestion.cod_departamento);
                $("#ciudad_id_nac").val(suggestion.cod_ciudad);
            }
        });

        $('#conflicto').change(function() {
            if ($(this).val() == 1){
                $('#descripcion_conflicto').show();
            }else{
                if ($(this).val() == 0){
                    $('#descripcion_conflicto').hide();
                }
            }
        });

        var inputs = "textarea[maxlength]";

        $('#ciudad_autocomplete_ex').autocomplete({
            serviceUrl: '{{ route("autocomplete_cuidades") }}',
            autoSelectFirst: true,
            onSelect: function (suggestion) {
                $("#pais_id_ex").val(suggestion.cod_pais);
                $("#departamento_id_ex").val(suggestion.cod_departamento);
                $("#ciudad_id_ex").val(suggestion.cod_ciudad);
            }
        });

        $('#ciudad_autocomplete_res').autocomplete({
            serviceUrl: '{{ route("autocomplete_cuidades") }}',
            autoSelectFirst: true,
            onSelect: function (suggestion) {
                $("#pais_id_res").val(suggestion.cod_pais);
                $("#departamento_id_res").val(suggestion.cod_departamento);
                $("#ciudad_id_res").val(suggestion.cod_ciudad);
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

        $("#c-numero_id").on('paste', function(e) {
            e.preventDefault();
            alert('Esta acción está prohibida');
        })

        $("#c-numero_id").on('copy', function(e) {
            e.preventDefault();
            alert('Esta acción está prohibida');
        })

        var pass1 = $('#numero_id');
        var pass2 = $('#c-numero_id');
        var clave = $('#password');

        var confirmacion = "Las cédulas si coinciden";
        var longitud = "La cédula debe estar formada entre 1-16 carácteres (ambos inclusive)";
        var negacion = "No coinciden las cédulas";
        var vacio = "La contraseña no puede estar vacía";

        //oculto por defecto el elemento span
        var span = $('<span></span>').insertAfter(pass2);
        span.hide();

        //función que comprueba las dos contraseñas
        function coincidePassword(){
            var valor1 = pass1.val();
            var valor2 = pass2.val();

            //muestro el span
            span.show().removeClass();
            
            //condiciones dentro de la función
            if((valor1 != valor2) && (valor2 != "")) {
                span.css("color", "red");
                span.text(negacion);
                $('.guardarDatosBasicos').attr('disabled',true);
            }

            if(valor1.length != 0 && valor1 == valor2) {
                span.css("color", "skyblue");
                span.text(confirmacion);
                $('.guardarDatosBasicos').removeAttr('disabled');
            }
        }

        //ejecuto la función al soltar la tecla
        pass2.on('input',function() {
            coincidePassword();
        });

        pass1.on('input',function() {
            coincidePassword();
        });

        clave.focus(function(event) {
            /* Act on the event */
            $('.mensaje1').remove();
            $('<span class="mensaje1">Ingresa la cédula como contraseña</span>').insertAfter(this);
        });

        //fortalezas_cargo();
        licencia();
        situacion_militar();
        vehiculo();
            
        $(document).on("change", "#genero", function () {
            genero();
        });

        $(document).on("change", "[name='tiene_licencia']", function () {
            $('[name="categoria_licencia"]').val('');
            $('[name="numero_licencia"]').val('');
            licencia();
        });

        $(document).on("change", "#tiene_vehiculo", function () {
            $('#tipo_vehiculo').val('');
            vehiculo();
        });

        function genero(){
            valu = $('#genero').val();

            if(valu == 1) {
                str = $("#nombres").val();

                $("#nombres").show();
                $("#situacion_militar").show();
            }else {
                $("#situacion_militar").hide();
            }
        }

        function licencia() {
            if ($('[name="tiene_licencia"]').val() == 1) {
                $('[name="categoria_licencia"]').parent('div').parent('div').show();
                $('[name="numero_licencia"]').parent('div').parent('div').show();
            }else {
                $('[name="categoria_licencia"]').parent('div').parent('div').hide();
                $('[name="numero_licencia"]').parent('div').parent('div').hide();
            }
        }

        function vehiculo() {
            if($('#tiene_vehiculo').val() == 1) {
              $('#tipo_vehiculo').parent('div').parent('div').show();
            }else {
              $('#tipo_vehiculo').parent('div').parent('div').hide();
            }
        }
            
        //situacion militar definida
        $(document).on('change', '.militar_situacion', function(event) {
            situacion_militar();
        })

        function situacion_militar() {
            var value = $('.militar_situacion').val();

            if( value == 1) {
                $('.libreta_militar').show();
            }else{
                $('.libreta_militar').hide();
                $("#numero_libreta").val('');
                $("#clase_libreta").val('');
            }
        }
    });
</script>
@stop

