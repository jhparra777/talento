<div class="modal-header">
    <button aria-label="Close" class="close" data-dismiss="modal" type="button">
        <span aria-hidden="true">
            ×
        </span>
    </button>
    <div class="modal-title">
        <h4>
            <strong>Cancelar contratación</strong> 
        </h4>
        <h5>
        <strong>Candidato</strong> {{ $candidato->nombres }} {{ $candidato->primer_apellido }} | <strong>Requerimiento</strong> {{ $req_can->requerimiento_id }}
        </h5>
        
    </div>
</div>

<div class="modal-body" style="height: 60px;">
    {!! Form::open(["id" => "fr_cancelar_contra"]) !!}
        {!! Form::hidden('req_can', $req_can->id) !!}
        {!! Form::hidden('req_id', $req_id) !!}
        {!! Form::hidden('candidato', $candidato->user_id) !!}

        <div class="col-md-12 form-group">
            <label for="motivo" class="col-sm-12 control-label">Motivo <span class="text-danger">*</span></label>

            <div class="col-sm-12">
                {!! Form::select("motivo", $motivos, null, ["class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", "id" => "motivo"]); !!}
            </div>
        </div>
    {!! Form::close() !!}
</div>

<div class="modal-footer">
    <button class="btn btn-default | tri-px-2 tri-br-2 tri-border--none tri-transition-300" data-dismiss="modal" type="button">Cerrar</button>
    <button type="button" class="btn btn-success | tri-px-2 tri-br-2 tri-border--none tri-transition-300 tri-green" id="confirmar_cancelar_contratacion">Confirmar</button> 
</div>

<script>
    $(function(){
        $("#confirmar_cancelar_contratacion").on("click", function(){                
            if($('#motivo').val() == ''){
                $('#motivo').css('border-color', 'red');
                setTimeout(() => {
                    $('#motivo').css('border-color', '#d2d6de');
                }, 1500)
            }else{
                $.ajax({
                    type: "POST",
                    data: $("#fr_cancelar_contra").serialize(),
                    url: "{{ route('admin.contratacion.confirmar_cancelar_contratacion_asistente') }}",
                    beforeSend : function () {
                        mensaje_success("Cancelando ...");
                    },
                    success: function (response) {
                        mensaje_success("Contratación cancelada.");
                        $("#modalTriSmall").modal("hide");

                        setTimeout(() => {
                            window.location.reload(true)
                        }, 1500);
                    }
                });
            }
        });
    });
</script>