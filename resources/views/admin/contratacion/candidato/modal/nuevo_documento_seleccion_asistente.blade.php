<div class="modal-header">
    
    <button aria-label="Close" class="close" data-dismiss="modal" type="button">
        <span aria-hidden="true">×</span>
    </button>

    <h4 class="modal-title"><b>Carga de documento</b></h4>
</div>

<div class="modal-body">
	{!! Form::model(Request::all(),["id" => "fr_nuevo_documento_seleccion", "files" => true, "data-smk-icon" => "glyphicon glyphicon-remove"]) !!}
        <div class="modal-body">
            <input type="hidden" name="cand_id" id="cand_id" value="{{$cand_id}}">

            <div class="col-md-12">
                <div class="form-group">
                    <label for="tipo_documento_id" class="control-label" style="color: black;"> Tipo documento</label>

                    {!! Form::select("tipo_documento_id",$tipo_documento,null,["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", "required" => "required"]); !!}

                    <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("tipo_documento",$errors) !!}</p>
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group">
                    <label for="archivo_documento" class="control-label" style="color: black;"> Archivo</label>

                    {!! Form::file("archivo_documento[]",["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", "accept"=>".pdf,.doc,.docx,.png,.jpg,.jpeg", "multiple"=>"true", "required" => "required"]) !!}

                    <p id="error_tipo" style="color: red;text-align: center;"></p>
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group">
                    <label for="fecha_vencimiento" class="control-label" style="color: black;"> Fecha de vencimiento</label>

                    {!! Form::text("fecha_vencimiento",$campos['fecha_vencimiento'],["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300","id"=>"fecha_vencimiento","placeholder"=>"Fecha Vencimiento", "readonly" => "readonly"]) !!}

                    <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("fecha_vencimiento",$errors) !!}</p>
                </div>
            </div>

            <div class="clearfix"></div>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-default | tri-px-2 tri-br-2 tri-border--none tri-transition-300" data-dismiss="modal">Cerrar</button>
            <button type="button" class="btn btn-success | tri-px-2 tri-br-2 tri-border--none tri-transition-300 tri-green"  id="guardar_nuevo_doc">Guardar</button>
        </div>
    {!! Form::close() !!}

<script>
    $(function(){
        $("#fecha_vencimiento").datepicker(confDatepicker);

    	$("#guardar_nuevo_doc").on("click", function(){
            if ($('#fr_nuevo_documento_seleccion').smkValidate()) {

                var formData = new FormData(document.getElementById("fr_nuevo_documento_seleccion"));

                $.ajax({
                    url: "{{route('admin.guardar_documento_asistente_seleccion')}}",
                    type: "post",
                    dataType: "html",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    beforeSend: function(){
                        $.smkAlert({
                            text: 'Guardando documentos ...',
                            type: 'info'
                        })
                        $("#modal_peq").modal("hide");
                    },
                    success: function(response) {
                        var res = JSON.parse(response);
                    
                        if(res.success) {
                            mensaje_success(res.mensaje);
                            setTimeout(() => {
                                location.reload(true);
                            }, 1000)
                        }else{
                            mensaje_danger(res.mensaje);
                        }
                    },
                    error: function () {

                    }
                });
            }
    	});
    	
    })
</script>

</div>