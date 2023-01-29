@extends("admin.layout.master")
@section('contenedor')
<style type="text/css">
    .py-0 {
        padding-bottom: 0px; padding-top: 0px;
    }

    .scroll-doc {
        max-height: 300px; overflow: scroll;
    }

    .mb-0 {
        margin-bottom: 0px;
    }

    .pagination{ margin: 0 !important; }

    .mb-1{ margin-bottom: 1rem; }
    .mb-2{ margin-bottom: 2rem; }
    .mb-3{ margin-bottom: 3rem; }
    .mb-4{ margin-bottom: 4rem; }

    .help-block.smk-error-msg {
        padding-right: 15px;
    }

    .btn-primary {
        background-color: #337ab7 !important;
        border-color: #2e6da4 !important;
    }

    .font-size-11 {
        font-size: 11pt;
    }

    .py-8 {
        padding-top: 8px;
        padding-bottom: 8px;
    }

    .error-smg-valor {
        color: #dd4b39;
        padding-right: 15px;
        position: absolute;
        right: 0;
        font-size: 12px;
        margin-top: 0;
        margin-bottom: 0;
        display: none;
    }
</style>

    {{-- Header --}}
    @include('admin.layout.includes._section_header_breadcrumb', ['page_header' => "Nuevo cargo especifico"])

    <div class="row">
        @if(Session::has("msg_error"))
            <div class="col-md-12" id="mensaje-resultado">
                <div class="alert alert-warning alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    {!! Session::get("msg_error") !!}
                </div>
            </div>
        @endif

        {!! Form::open(["id" => "fr_cargos_especificos", "route" => "admin.cargos_especificos.guardar", "method" => "POST", "files" => true]) !!}
            {!! Form::hidden("id") !!}
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="col-md-6 form-group">
                            <label class="control-label" for="descripcion">Nombre del cargo *</label>
                            {!! Form::text("descripcion", null, ["class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", "placeholder" => "Nombre del cargo", "required" => "required"]); !!}

                            <p class="error text-danger direction-botones-center" style="{{ ($errors->has('descripcion') ? '' : 'display: none;') }}">
                                {!! FuncionesGlobales::getErrorData("descripcion", $errors) !!}
                            </p>
                        </div>

                        <div class="col-md-6 form-group">
                            <label class="control-label" for="cargo_generico_id">Cargo Genérico: *</label>
                            {!! Form::select("cargo_generico_id", $cargosGenericos, null, ["class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", "id" => "cargosGenericoId", "required" => "required"]); !!}

                            <p class="error text-danger direction-botones-center" style="{{ ($errors->has('cargo_generico_id') ? '' : 'display: none;') }}">
                                {!! FuncionesGlobales::getErrorData("cargo_generico_id", $errors) !!}
                            </p>
                        </div>


                        <div class="col-md-6 form-group">
                            <label class="control-label" for="clt_codigo">Cliente:</label>

                            {!! Form::select('clt_codigo', $clientes, null, ['class' => 'form-control js-select-2-basic', "id" => "cliente_select", "required" => "required"]) !!}

                            <p class="error text-danger direction-botones-center" style="{{ ($errors->has('clt_codigo') ? '' : 'display: none;') }}">
                                {!! FuncionesGlobales::getErrorData("clt_codigo", $errors) !!}
                            </p>
                        </div>


                        {{-- Validación de contratación virtual --}}
                        @if($sitio->asistente_contratacion == 1)
                            <div class="col-md-6 form-group">
                                <label class="control-label" for="firma_digital">Contratación virtual *</label>
                                {!! Form::select("firma_digital", [1 => "Si", 0 => "No"], null, ["class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", "id" => "firma_digital", "required" => "required"]); !!}

                                <p class="error text-danger direction-botones-center" style="{{ ($errors->has('firma_digital') ? '' : 'display: none;') }}">
                                    {!! FuncionesGlobales::getErrorData("firma_digital", $errors) !!}
                                </p>
                            </div>

                            <div class="col-md-6 form-group" id="videos_box">
                                <label class="control-label" for="videos_contratacion">¿Video confirmación? *</label>
                                {!! Form::select("videos_contratacion", [1 => "Si", 0 => "No"], null, ["class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", "id" => "videos_contratacion"]); !!}

                                <p class="error text-danger direction-botones-center" style="{{ ($errors->has('videos_contratacion') ? '' : 'display: none;') }}">
                                    {!! FuncionesGlobales::getErrorData("videos_contratacion", $errors) !!}
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

        {!! Form::close() !!}

    </div>

    <script type="text/javascript">
        @if($sitio->asistente_contratacion == 1)
            const $firma_digital = document.querySelector('#firma_digital');
            const $videos_box = document.querySelector('#videos_box');
            const $video_con = document.querySelector('#videos_contratacion');

            //$videos_box.style.display = 'none';

            $firma_digital.addEventListener('change', (e) => {
                if (e.target.value == 1) {
                    $videos_box.style.display = 'initial';
                    $video_con.value = 1;
                }

                if (e.target.value == 0) {
                    $videos_box.style.display = 'none';
                    $video_con.value = 0;
                    // console.log($video_con.value);
                }
            })
        @endif

        $(".solo-numero").keydown(function(event) {
            if(event.shiftKey){
                event.preventDefault();
            }
            
            if (event.keyCode == 46 || event.keyCode == 8){
            }
            else{
                if (event.keyCode < 95) {
                    if(event.keyCode < 48 || event.keyCode > 57) {
                     event.preventDefault();
                    }
                } 
                else {
                    if(event.keyCode < 96 || event.keyCode > 105) {
                      event.preventDefault();
                    }
                }
            }
        });

        $("#plazo_req").attr("readonly","true");

        $("#tipo_cargo").change(function(){
            if($(this).val()!=""){
                var valor=$(this).val();
                
                switch (valor) {
                    case "1":
                        $("#plazo_req").val(62);
                    break;

                    case "2":
                        $("#plazo_req").val(36);
                    break;

                    case "3":
                        $("#plazo_req").val(43);
                    break;

                    case "4":
                        $("#plazo_req").val(59);
                    break;
                }
            }
        });

        $("#crear_preg").on("click", function (){
            var req_id = $(this).data("req");
            var cargo_id = $(this).data("cargo_id");

            $.ajax({
                data: {req_id: req_id,cargo_id: cargo_id},
                url: "{{route('admin.crear_pregunta_req')}}",
                success: function (response) {
                    $("#modal_gr").find(".modal-content").html(response);
                    $("#modal_gr").modal("show");
                }
            });
        });

        $("#seleccionar_todos_c").on("change", function () {
            var obj = $(this);
            $(".contratacion-d").prop("checked", obj.prop("checked"));
        })

        $("#seleccionar_todos_clausulas").on("change", function () {
            let obj = $(this);
            let checkAdicionales = $(".contratacion-clausulas")

            $(".contratacion-clausulas").prop("checked", obj.prop("checked"));

            for (let index = 0; index < checkAdicionales.length; index++) {
                let campo = $(`#${checkAdicionales[index]['id']}`).parents('.item_adicional').find('#valor_adicional').eq(0)
                //let campo = checkAdicionales[index].parents('.item_adicional').find('#valor_adicional').eq(0);

                if(checkAdicionales[index]['checked']) {
                    //campo.attr("placeholder", "Ingrese código");
                    campo.attr('disabled' ,false);
                }else {
                    campo.val("");
                    campo.attr("placeholder", "Valor variable");
                    campo.attr("disabled", true);
                }
            }
        })

        $("#seleccionar_todos_s").on("change", function () {
            var obj = $(this);
            $(".seleccion-d").prop("checked", obj.prop("checked"));
        });

        $("#seleccionar_todos_p").on("change", function () {
            var obj = $(this);
            $(".postcontratacion-d").prop("checked", obj.prop("checked"));
        });

        $("#seleccionar_todos_e").on("change", function () {
            var obj = $(this);
            $(".examenes_cargo").prop("checked", obj.prop("checked"));
        });

        $('#check_adicionales').change(function(){
            let campo = $(this).parents('.item_adicional').find('#valor_adicional').eq(0);

            if($(this).prop('checked')) {
                //campo.attr("placeholder", "Ingrese código");
                campo.attr('disabled' ,false);
            }else {
                campo.val("");
                campo.attr("placeholder", "Valor variable");
                campo.attr("disabled", true);
            }
        });

        $("#excel_basico").on("change", function () {
            var obj = $(this);
            if (obj.prop("checked")) {
                $(".porcentaje-excel-basico").show();
                $("#aprobacion_excel_basico").prop('required', 'required');
                $("#tiempo_excel_basico").prop('required', 'required');
            } else {
                $(".porcentaje-excel-basico").hide();
                $("#aprobacion_excel_basico").removeAttr('required');
                $("#tiempo_excel_basico").removeAttr('required');
            }
        });

        $("#excel_intermedio").on("change", function () {
            var obj = $(this);
            if (obj.prop("checked")) {
                $(".porcentaje-excel-intermedio").show();
                $("#aprobacion_excel_intermedio").prop('required', 'required');
                $("#tiempo_excel_intermedio").prop('required', 'required');
            } else {
                $(".porcentaje-excel-intermedio").hide();
                $("#aprobacion_excel_intermedio").removeAttr('required');
                $("#tiempo_excel_intermedio").removeAttr('required');
            }
        });

        $(document).on("click", "#guardar_preg", function () {
            $(this).prop("disabled", false)

            $.ajax({
                type: "POST",
                data: $("#fr_preg").serialize(),
                url: "{{ route('admin.guardar_pregunta_cargo') }}",
                success: function (data) {
                    $("#modal_gr").modal("hide");
                    mensaje_success("Pregunta creada con éxito!!");
                }
            });
        });

        $(function(){
            $(".estudioSeguridadOculto").hide();
            $(".examenMedicoOculto").hide();

            $('#estudioSeguridad').change(function(){
                if(!$(this).prop('checked')){
                    $('.estudioSeguridadOculto').hide();
                }else{
                    $('.estudioSeguridadOculto').show();
                }
            })

            $('#examesMedicos').change(function(){
                if(!$(this).prop('checked')){
                    $('.examenMedicoOculto').hide();
                }else{
                    $('.examenMedicoOculto').show();
                }
            })

            $('.js-select-2-basic').select2({
                placeholder: 'Selecciona o busca un cliente'
            });

            $('.btn-guardar-cargo').click(function() {
                $("#error-excel-basico").hide();
                $("#error-excel-intermedio").hide();
                $("#error-tiempo-excel-basico").hide();
                $("#error-tiempo-excel-intermedio").hide();
                if($('#fr_cargos_especificos').smkValidate()) {
                    if($("#excel_basico").prop("checked") && ($("#aprobacion_excel_basico").val() < 10 || $("#aprobacion_excel_basico").val() > 100) ) {
                        $("#error-excel-basico").show();
                        return false;
                    }
                    if($("#excel_intermedio").prop("checked") && ($("#aprobacion_excel_intermedio").val() < 10 || $("#aprobacion_excel_intermedio").val() > 100)) {
                        $("#error-excel-intermedio").show();
                        return false;
                    }
                    if($("#excel_basico").prop("checked") && ($("#tiempo_excel_basico").val() < 10 || $("#tiempo_excel_basico").val() > 45) ) {
                        $("#error-tiempo-excel-basico").show();
                        return false;
                    }
                    if($("#excel_intermedio").prop("checked") && ($("#tiempo_excel_intermedio").val() < 10 || $("#tiempo_excel_intermedio").val() > 45)) {
                        $("#error-tiempo-excel-intermedio").show();
                        return false;
                    }
                    $('.btn-guardar-cargo').hide();
                    $('#fr_cargos_especificos').submit();
                }
            });
        });
    </script>
@stop