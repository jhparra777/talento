<div class="modal-header">
    
    <button aria-label="Close" class="close" data-dismiss="modal" type="button">
        <span aria-hidden="true">×</span>
    </button>

    <h4 class="modal-title">Carga de documento</h4>
</div>

<div class="modal-body">
	{!! Form::model(Request::all(),["id" => "fr_nuevo_documento_seleccion", "files" => true, "data-smk-icon" => "glyphicon glyphicon-remove"]) !!}
        {!! Form::hidden('cliente_id',$cliente_id)!!}
        <div class="modal-body">
            <input type="hidden" name="cand_id" id="cand_id" value="{{$cand_id}}">

            <div class="col-md-12">
                <div class="form-group">
                    <label for="tipo_documento_id" class="control-label" style="color: black;"> Tipo documento</label>

                    {!! Form::select("tipo_documento_id",$tipo_documento,null,["class"=>"form-control", "required" => "required"]); !!}

                    <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("tipo_documento",$errors) !!}</p>
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group">
                    <label for="archivo_documento" class="control-label" style="color: black;"> Archivo</label>

                    {!! Form::file("archivo_documento",["class"=>"form-control", "accept"=>".pdf,.doc,.docx,.png,.jpg,.jpeg", "multiple"=>"true", "required" => "required"]) !!}

                    <p id="error_tipo" style="color: red;text-align: center;"></p>
                </div>
            </div>

            <div class="clearfix"></div>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            <button type="button" class="btn btn-success"  id="guardar_nuevo_doc">Guardar</button>
        </div>
    {!! Form::close() !!}

<script>
    $(function(){
    	$("#guardar_nuevo_doc").on("click", function(){
            if ($('#fr_nuevo_documento_seleccion').smkValidate()) {

                var formData = new FormData(document.getElementById("fr_nuevo_documento_seleccion"));

                $.ajax({
                    url: "{{route('admin.gestion_documental.guardar_documento_cliente')}}",
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