<div class="modal-header">
    <button aria-label="Close" class="close" data-dismiss="modal" type="button">
        <span aria-hidden="true">×</span>
    </button>

    <h4 class="modal-title">Carga de documento</h4>
</div>

<div class="modal-body">
	{!! Form::model(Request::all(),["id" => "fr_nuevo_documento_seleccion", "files" => true]) !!}
        <div class="modal-body">
            {!! Form::hidden("ref_id") !!}
            <input type="hidden" name="cand_id" id="cand_id" value="{{$cand_id}}">

            <div class="col-md-12 form-group">
                <label for="inputEmail3" class="col-sm-4 control-label"> Tipo documento</label>

                <div class="col-sm-8">
                    {!! Form::select("tipo_documento_id",$tipo_documento,null,["class"=>"form-control"]); !!}
                </div>

                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("tipo_documento",$errors) !!}</p>
            </div>

            <div class="col-md-12 form-group">
                <label for="inputEmail3" class="col-sm-4 control-label"> Archivo</label>

                <div class="col-sm-8">
                    {!! Form::file("archivo_documento", ["class" => "form-control", "accept" => ".pdf,.doc,.docx,.png,.jpg,.jpeg"]); !!}
                </div>
                <p id="error_tipo" style="color: red;text-align: center;"></p>
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
            var formData = new FormData(document.getElementById("fr_nuevo_documento_seleccion"));

            $.ajax({
                url: "{{route('req.guardar_documento_asistente_seleccion')}}",
                type: "post",
                dataType: "html",
                data: formData,
                cache: false,
                contentType: false,
                processData: false
            }).done(function (res) {
                var success = JSON.parse(res);
                
                if(success.success == false){
                    $("#error_tipo").html("");
                    $("#error_tipo").html(success.error);
                }
                else{
                    $("#error_tipo").html("");
                    mensaje_success("Documento cargado con exito");
                    location.reload(); 
                }
            });
    	})
    })
</script>

</div>