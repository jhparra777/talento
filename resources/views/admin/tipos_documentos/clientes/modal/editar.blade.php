<link rel="stylesheet" href="{{ asset("js/bootstrap-select/dist/css/bootstrap-select.min.css") }}">
<div class="modal-header">
    
    <button aria-label="Close" class="close" data-dismiss="modal" type="button">
        <span aria-hidden="true">×</span>
    </button>

    <h4 class="modal-title">Editar tipo documento</h4>
</div>

<div class="modal-body">
	{!! Form::model(Request::all(),["id" => "fr_nuevo_documento_seleccion", "files" => true, "data-smk-icon" => "glyphicon glyphicon-remove"]) !!}
        {!! Form::hidden('tipo_id',$registro->id)!!}
        <div class="modal-body">
            <div class="col-md-8 col-md-offset-2 form-group">
                <label for="inputEmail3" class="control-label">Descripción:</label>

                            
                {!! Form::text("descripcion",$registro->descripcion,["class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300" ]); !!}
                            
            </div>

            <div class="col-md-8 col-md-offset-2 form-group">
                <label for="inputEmail3" class="control-label">Categoría:</label>

                            
                {!! Form::select("categoria_id[]",$categorias,null,["class"=>"selectpicker form-control","multiple"=>true,"data-actions-box"=>true ]); !!}
                            
            </div>

            <div class="col-md-8 col-md-offset-2 form-group">
                <label for="inputEmail3" class="control-label">Estado:</label>

                            
                {!! Form::select("active",[1=>"Activo",2=>"Inactivo"], $registro->active,["class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300" ]); !!}
                            
            </div>

            <div class="clearfix"></div>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-default | tri-br-2 tri-transition-200 tri-hover-out-gray" data-dismiss="modal">Cerrar</button>
            <button 
                type="submit"
                class="btn btn-default | tri-br-2 tri-txt-green tri-bg-white tri-bd-green tri-transition-200 tri-hover-out-green" 
                id="guardar">
                Guardar
            </button>
        </div>
    {!! Form::close() !!}

<script src="{{ asset("js/bootstrap-select/dist/js/bootstrap-select.min.js") }}"></script>
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