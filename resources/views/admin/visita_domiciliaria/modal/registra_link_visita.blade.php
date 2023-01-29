<div class="modal-header">
    <button aria-label="Close" class="close" data-dismiss="modal" type="button">
        <span aria-hidden="true">×</span>
    </button>

    <h4 class="modal-title"><b>Registro de enlace visita domiciliaria</b></h4>
</div>

<div class="modal-body">
    {!! Form::model(Request::all(),["id" => "frm_registro_link", "data-smk-icon" => "glyphicon glyphicon-remove"]) !!}
        <div class="modal-body">

            <input type="hidden" name="visita" id="visita" value="{{$visita}}">

            

            <div class="col-md-12 form-group">
                <label class="control-label" for="inputEmail3">
                    Enlace de visita domiciliaria
                </label>
                <input 
                name="link_visita_virtual"
                type="url"
                class="form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300"
                id="link_visita_virtual"
                required
                >
    
            </div>

            <div class="clearfix"></div>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-default | tri-px-2 tri-br-2 tri-border--none tri-transition-200" data-dismiss="modal">Cerrar</button>
            <button type="button" class="btn btn-success | tri-px-2 tri-br-2 tri-border--none tri-transition-300 tri-green"  id="btn_guardar_link">Guardar</button>
        </div>
    {!! Form::close() !!}
</div>
<script>

    //se valida para enviar
    $('#btn_guardar_link').on("click", function(){
        //event.preventDefault()
        if ($('#frm_registro_link').smkValidate()) {
            $('#btn_guardar_link').hide();
            let formData = new FormData(document.getElementById("frm_registro_link"));
            let visita = document.getElementById("visita").value;
            let link_visita_virtual = document.getElementById("link_visita_virtual").value;
            console.log(visita)
            $.ajax({
                type: "POST",
                // data: { visita: visita, link_visita_virtual:link_visita_virtual },
                data: formData,
                url: "{{ route('admin.guardar_enlace_visita') }}",
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function(){
                    $.smkAlert({
                        text: 'Guardando...',
                        type: 'info'
                    });
                },
                error: function(){
                    $.smkAlert({
                        text: 'Ha ocurrido un error guardando. Verifique e intente nuevamente.',
                        type: 'danger'
                    });
                    $('#btn_guardar').show();
                },
                success: function(response){
                    if(response.success) {
                        $.smkAlert({
                            text: 'Datos guardados correctamente!',
                            type: 'success'
                        });
                        $("#modal_peq").modal("hide");
                        $('#frm_registro_link').smkClear();
                        // setTimeout(() => {
                        //     location.reload(true);
                        // }, 2000)
                    } else {
                        $.smkAlert({
                            text: response.mensaje,
                            type: 'danger'
                        });
                        $('#btn_guardar').show();
                    }
                }
            });
        }
    });
</script>