<div class="modal-header">
     <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
     <h4 class="modal-title">Datos del candidato</h4>
</div>

<div class="modal-body">
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-info | tri-br-1 tri-blue-2 tri-border--none" role="alert" style="display: none;" id="asociado">
                <i class="fas fa-info-circle"></i> Este candidato ya está activo en este requerimiento.
            </div>

            @if(isset($email_error))
                <div class="alert alert-info | tri-br-1 tri-blue-2 tri-border--none" id="email_error" role="alert">
                    {{ $email_error }}
                </div>
            @endif
        </div>

        {!! Form::model(Request::all(), ["route" => (!empty($datos["id"])) ? "admin.actualizar_candidato_fuente" : "admin.guardar_candidato_fuente", "id" => "fr_otra_fuente"]) !!}
            {{ csrf_field() }}

            {!! Form::hidden("requerimiento_id", $datos["requerimiento_id"], ["id" => "requerimiento_id"]) !!}
            {!! Form::hidden("cand_otra_id", (!empty($datos["id"])) ? $datos["id"] : "") !!}

            <div class="col-md-12" style="display: flex; align-items: end;">
                <div class="col-md-12 form-group">
                    <label for="cedula">Cédula *</label>

                    <div class="input-group">
                        <input type="text" name="cedula" id="cedula" value="{{ (!empty($datos['cedula'])) ? $datos['cedula'] : '' }}" class="form-control solo-numero input-number | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300" required style="border-radius: 1rem 0rem 0rem 1rem;">

                        <span class="input-group-btn">
                            <button type="button" id="buscar_candidato" class="btn btn-success btn-flat | text-white tri-border--none tri-transition-200 tri-green" style="border-radius: 0rem 1rem 1rem 0rem;">
                                Buscar <i class="fas fa-search"></i>
                            </button>
                        </span>
                    </div>
                </div>

                <div class="col-md-3">
                    <button type="button" class="btn btn-default | tri-px-2 text-white tri-br-2 tri-border--none tri-transition-200 tri-red" id="limpiar_otra_fuente" style="display: none; margin-bottom: 1.6rem;">Limpiar</button>
                </div>
            </div>

            <div id="data"></div>
        {!! Form::close() !!}
    </div>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-default | tri-br-2 tri-border--none tri-transition-200" data-dismiss="modal"> Cerrar </button>
    <button type="button" class="btn btn-default | text-white tri-br-2 tri-border--none tri-transition-200 tri-d-yellow" id="guardar_candidato_fuente"> Agregar otras fuentes </button>
    <button type="button" class="btn btn-default | text-white tri-br-2 tri-border--none tri-transition-200 tri-green" id="asociar_directo" disabled> Asociar al requerimiento </button>
    <button type="submit" class="btn btn-default | text-white tri-br-2 tri-border--none tri-transition-200 tri-green" id="asociar_directo_submit">Asociar al requerimiento</button>

    {!! Form::model(Request::all(), ["route" => "admin.agregar_candidato_fuentes", "id" => "fr_asociar_directo"]) !!}
        {{ csrf_field() }}

        {!! Form::hidden("requerimiento_id", $datos["requerimiento_id"], ["id" => "req_id", "form" => "fr_asociar_directo"]) !!}

        <input name="aplicar_candidatos_fuentes[]" type="hidden" value="{{ (!empty($datos['cedula'])) ? $datos['cedula'] : '' }}" id="candidato_a_asociar">

        {!! Form::hidden("cedula", (!empty($datos["cedula"])) ? $datos["cedula"] : "", ["class" => "form-control input-number", "id" => "cedula_otro", "form" => "fr_asociar_directo"]); !!}

        {{--{!! Form::hidden("nombres", (!empty($candidato->nombres)) ? $candidato->nombres : "", ["class" => "form-control", "id" => "nombres_otro", "form" => "fr_asociar_directo"]); !!}--}}

        {!! Form::hidden("primer_nombre", (!empty($candidato->primer_nombre)) ? $candidato->primer_nombre : "", ["class" => "form-control", "id" => "primer_nombre_otro", "form" => "fr_asociar_directo"]); !!}

        {!! Form::hidden("segundo_nombre", (!empty($candidato->segundo_nombre)) ? $candidato->segundo_nombre : "", ["class" => "form-control", "id" => "segundo_nombre_otro", "form" => "fr_asociar_directo"]); !!}

        {!! Form::hidden("primer_apellido", (!empty($candidato->primer_apellido)) ? $candidato->primer_apellido : "", ["class" => "editables form-control", "id" => "primer_apellido_otro", "form" => "fr_asociar_directo"]); !!}

        {!! Form::hidden("segundo_apellido", (!empty($candidato->segundo_apellido)) ? $candidato->segundo_apellido : "", ["class" => "editables form-control", "id" => "segundo_apellido_otro", "form" => "fr_asociar_directo"]); !!}

        {!! Form::hidden("email", (!empty($datos["email"])) ? $datos["email"] : "", ["class" => "form-control", "id" => "email_otro", "form" => "fr_asociar_directo"]); !!}

        {!! Form::hidden("celular", (!empty($candidato->telefono_movil)) ? $candidato->telefono_movil : "", ["class" => "form-control numerico", "id" => "celular_otro", "form" => "fr_asociar_directo"]); !!}

        {!! Form::hidden("tipo_fuente_id", (!empty($candidato->tipo_fuente_id)) ? $candidato->tipo_fuente_id : "", ["class" => "form-control hidden", "id" => "tipo_fuente_otro", "form" => "fr_asociar_directo"]); !!}
    {!! Form::close() !!}
</div>

<script>
    $(function() {
        $("#guardar_candidato_fuente").hide();
        $("#asociar_directo_submit").hide();
        $("#asociar_directo").hide();

        $("#buscar_candidato").click(function(){
            if ($('#fr_otra_fuente').smkValidate()) {
                var cedula = $("#cedula").val();
                var req_id = $("#requerimiento_id").val();

                $.ajax({
                     url: "{{ route('admin.ajaxgetcandidato') }}",
                     type: 'POST',
                     data:{
                          cedula: cedula,
                          req_id: req_id
                     }
                }).done(function (response) {
                     $("#guardar_candidato_fuente").removeAttr("disabled");
                     $("#asociar_directo").removeAttr("disabled");

                     //Append response
                     $('#data').html(response.view);

                     $("#limpiar_otra_fuente").show();

                     if(response.find){
                        //  console.log(response.asociado);
                        //  console.log(response.p_contratacion);
                          if(response.asociado){
                               $("#asociar_directo").hide();
                               $("#asociar_directo_submit").hide();
                               $("#guardar_candidato_fuente").hide();
                               $("#asociado").show();
                          } else{
                               $("#asociar_directo").hide();
                               $("#asociar_directo_submit").show();
                               $("#candidato_a_asociar").val(response.candidato);
                               $("#guardar_candidato_fuente").show();
                               $("#asociado").hide();
                               $("#contratado").hide();
                          }
                     }else {
                          $("#asociar_directo").show();
                          $("#asociar_directo_submit").hide();
                          $("#guardar_candidato_fuente").show();
                     }
                })
            }
        })

        $("#limpiar_otra_fuente").click(function() {
            $("#asociar_directo").hide();
            $("#asociar_directo_submit").hide();
            $("#guardar_candidato_fuente").hide();
            $('#fr_otra_fuente #cedula').val('');
            $('#fr_otra_fuente #cedula').attr('readonly', false);
            $("#limpiar_otra_fuente").hide();
            $("#asociado").hide();
            $("#contratado").hide();
            $('#data').html('');
        })

        $("#fr_otra_fuente").keypress(function(e) {
            if(e.which == 13) {
                return false;
            }
        });

        $("#asociar_directo_submit").click(function(e){
            if ($('#fr_otra_fuente').smkValidate()) {
                $.ajax({
                    type: "POST",
                    data: {
                        aplicar_candidatos_fuentes:[ $("#fr_otra_fuente #cedula").val()],
                        requerimiento_id:$("#fr_otra_fuente #requerimiento_id").val(),
                        cedula:$("#fr_otra_fuente #cedula").val(),
                        nombres:$("#fr_otra_fuente #nombres").val(),
                        primer_nombre:$("#fr_otra_fuente #primer_nombre").val(),
                        segundo_nombre:$("#fr_otra_fuente #segundo_nombre").val(),
                        celular:$('#fr_otra_fuente #celular').val(),
                        primer_apellido:$("#fr_otra_fuente #primer_apellido").val(),
                        segundo_apellido:$("#fr_otra_fuente #segundo_apellido").val(),
                        email:$("#fr_otra_fuente #email").val(),
                        tipo_fuente_id: $("#fr_otra_fuente #tipo_fuente_id").val(),
                        _token: $("#fr_otra_fuente input[name=_token]").val(),
                        asociar_directo: true
                    },
                    url: "{{route('admin.agregar_candidato_fuentes')}}",
                    beforeSend: function(){
                        $("#modalTriSmall").modal("hide");
                        mensaje_success('Espere mientras se agrega el candidato');
                    },
                    success: function(response) {
                        if(response.success) {
                            if (response.transferir_directo) {
                                location.reload();
                            } else {
                                $("#modal_success").modal("hide");
                                $("#modalTriLarge").find(".modal-content").html(response.view);
                                $("#modalTriLarge").modal("show");
                            }
                        } else{
                            if (response.mensaje != null) {
                                mensaje_danger(response.mensaje);
                                setTimeout(function(){
                                    location.reload();
                                }, 2000);
                                return false;
                            }
                        }
                    }
                });
            }
        })
    })
</script>