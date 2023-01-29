<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <div class="modal-title">
        @if($solicitud != null)
            <h4>
                <strong>
                    Gestionar solicitud de adelanto de nómina #{{$solicitud->id}}
                </strong>
            </h4>
            <h5>
                <strong>Contratado</strong> {{ $solicitud->nombres." ".$solicitud->primer_apellido}} | <strong>{{$solicitud->cod_tipo_identificacion}}</strong> {{$solicitud->numero_id }}
            </h5>
        @else
            <h4>
                <strong>No se encontró la información.</strong>
            </h4>
        @endif
    </div>
</div>

<div class="modal-body">
    @if($solicitud != null)
        {!! Form::model(Request::all(),["id" => "fr_adelanto_nomina", "files" => true, "data-smk-icon" => "fa fa-times-circle"]) !!}
            {!! Form::hidden("solicitud_id", $solicitud->id, ["id" => "solicitud_id"]) !!}

            <div class="col-md-12">
                <div class="form-group">
                    <label for="solicitud_aprobada" class="control-label">Aprobar <span class="text-danger">*</span></label>

                    {!! Form::select("solicitud_aprobada", ['' => 'Seleccionar', 'SI' => 'SI', 'NO' => 'NO'], null, [
                        "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                        "id" => "solicitud_aprobada",
                        "required" => "required"
                        ]);
                    !!}
                </div>
            </div>

            <div class="col-md-12" hidden id="div_motivo_rechazo">
                <div class="form-group">
                    <label for="motivo_rechazo" class="control-label">Motivo <span class="text-danger">*</span></label>

                    {!! Form::select("motivo_rechazo", $motivos_rechazo, null, [
                        "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                        "id" => "motivo_rechazo"
                        ]);
                    !!}
                </div>
            </div>

            <div class="col-md-12 div_aprobar" hidden>
                <div class="form-group">
                    <label for="fecha_transferencia" class="control-label">Fecha de la transferencia <span class="text-danger">*</span></label>

                    {!! Form::text("fecha_transferencia", null, [
                        "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                        "id" => "fecha_transferencia",
                        "readonly" => "readonly"
                        ]);
                    !!}
                </div>
            </div>

            <div class="col-md-12 div_aprobar" hidden>
                <div class="form-group">
                    <label for="hora_transferencia" class="control-label">Hora de la transferencia <span class="text-danger">*</span></label>

                    {!! Form::time("hora_transferencia", null, [
                        "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                        "id" => "hora_transferencia"
                        ]);
                    !!}
                </div>
            </div>

            <div class="col-md-12 div_aprobar" hidden>
                <div class="form-group">
                    <label for="codigo_transferencia" class="control-label">Código de la transferencia <span class="text-danger">*</span></label>

                    {!! Form::text("codigo_transferencia", null, [
                        "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                        "id" => "codigo_transferencia"
                        ]);
                    !!}
                </div>
            </div>

            <div class="col-md-12 div_aprobar" hidden>
                <div class="form-group">
                    <label for="documento_soporte" class="control-label">Soporte de la transferencia <span class="text-danger">*</span></label>

                    {!! Form::file("documento_soporte",["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", "accept"=>".pdf,.doc,.docx,.png,.jpg,.jpeg", "id" => "documento_soporte"]) !!}
                </div>
            </div>
        {!! Form::close()!!}
    @endif
    <div class="clearfix"></div>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-default | tri-px-2 tri-br-2 tri-border--none tri-transition-300" data-dismiss="modal">Cerrar</button>
    @if($solicitud != null)
        <button type="button" class="btn btn-success | tri-px-2 tri-br-2 tri-border--none tri-transition-300 tri-green" id="confirmar_gestion" >Confirmar</button>
    @endif
</div>

<script type="text/javascript">
    $(function () {
        var redireccionar = "{{ route('admin.lista_solicitudes_adelanto_nomina') }}";
        $('#solicitud_aprobada').change( function () {
            $('#div_motivo_rechazo').hide();
            $('#div_motivo_rechazo select').val('');
            $('#div_motivo_rechazo select').prop('required', false);

            $('.div_aprobar').hide();
            $('.div_aprobar input').val('');
            $('.div_aprobar input').prop('required', false);

            if ($(this).val() == 'SI') {
                $('.div_aprobar').show();
                $('.div_aprobar input').prop('required', true);
            } else if ($(this).val() == 'NO') {
                $('#div_motivo_rechazo').show();
                $('#div_motivo_rechazo select').prop('required', true);
            }
        });

        $("#confirmar_gestion").on("click", function(){
            if ($('#fr_adelanto_nomina').smkValidate()) {

                var formData = new FormData(document.getElementById("fr_adelanto_nomina"));

                $.ajax({
                    url: "{{route('admin.gestionar_solicitud_cartapp')}}",
                    type: "post",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    beforeSend: function(){
                        $.smkAlert({
                            text: 'Guardando información ...',
                            type: 'info'
                        })
                        $("#modalTriSmall").modal("hide");
                    },
                    success: function(response) {
                        if(response.success) {
                            mensaje_success(response.mensaje);
                            setTimeout(() => {
                                location.href=redireccionar;
                            }, 2000)
                        }else{
                            mensaje_danger(response.mensaje);
                        }
                    },
                    error: function () {

                    }
                });
            }
        });

        var confDatepickerNomina = {
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
            yearRange: "1930:2050",
            maxDate:new Date()
        };

        $("#fecha_transferencia").datepicker(confDatepickerNomina);
    });
</script>