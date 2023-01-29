<div class="modal-header">
    
    <button aria-label="Close" class="close" data-dismiss="modal" type="button">
        <span aria-hidden="true">×</span>
    </button>

    <h4 class="modal-title"><b>Carga de documento</b></h4>
</div>

<div class="modal-body">
	{!! Form::open(["class"=>"form-horizontal form-datos-basicos", "role"=>"form","files"=>true,"id"=>"fr_nuevo_documento_beneficiario"]) !!}
        <div class="modal-body">
            <input type="hidden" name="cand_id" id="cand_id" value="{{$cand_id}}">

            <div class="col-sm-6 col-lg-12 form-group">
                <label for="tipo_documento" class="col-md-4 control-label">Tipo Documento:<span class='text-danger sm-text-label'>*</span></label>
                                
                <div class="col-md-6">
                    {!! Form::select("tipo_documento_id",$tipos_documentos,null,["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300","id"=>"tipo_documento"]) !!}
                </div>
            </div>

            <div class="col-sm-6 col-lg-12 form-group">
                <label for="tipo_documento" class="col-md-4 control-label">Familiar:<span class='text-danger sm-text-label'>*</span></label>
                                
                <div class="col-md-6">
                    <select name="grupo_familiar_id" id="grupo_familiar_id" class="form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300">
                        <option value="">Seleccionar</option>
                        @foreach($gruposFamiliares as $familiar)
                            <option value="{{ $familiar->id }}">{{ $familiar->parentesco }} - {{ $familiar->nombres }} {{ $familiar->primer_apellido }} {{ $familiar->segundo_apellido }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-sm-6 col-lg-12 form-group">
                <label for="documento" class="col-md-4 control-label">Archivo Documento (jpg,png,pdf):<span class='text-danger sm-text-label'>*</span> </label>
                                
                <div class="col-md-6">
                    {!! Form::file("documento",["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300","placeholder"=>"Archivo Documento","accept"=>".jpg,.jpeg,.png,.pdf"]) !!}
                </div>
            </div>

            <div class="col-sm-6 col-lg-12 form-group">
                <label for="descripcion_documentos" class="col-md-4 control-label">Descripción:<span class='text-danger sm-text-label'>*</span> </label>
                                
                <div class="col-md-6">
                    {!! Form::text("descripcion",null,["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300","placeholder"=>"Descripción Documento","id"=>"descripcion"]) !!}
                </div>
            </div>

            <div class="clearfix"></div>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-default | tri-px-2 tri-br-2 tri-border--none tri-transition-300" data-dismiss="modal">Cerrar</button>
            <button type="button" class="btn btn-success | tri-px-2 tri-br-2 tri-border--none tri-transition-300 tri-green"  id="guardar_nuevo_doc_beneficiario">Guardar</button>
        </div>
    {!! Form::close() !!}

<script>
    $(function(){
    	$("#guardar_nuevo_doc_beneficiario").on("click", function(){

            var formData = new FormData(document.getElementById("fr_nuevo_documento_beneficiario"));

            $.ajax({
                url: "{{route('guardar_documento_familiar')}}",
                type: "post",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function(){
                    mensaje_success("Guardando documento ...");
                    
                },
                success: function(res) {
                
                    if(res.success == false){

                        $("#modal_success").modal("hide");
                        mensaje_danger(res.mensaje);

                    }else{
                        
                        $("#modal_gr").modal("hide");
                        mensaje_success("Documento cargado con éxito");                

                        setTimeout(() => {
                            location.reload(true);
                        }, 1000)
                    }
                },
                error: function (err) {
                    console.log(err);
                    mensaje_danger("Ocurrio un erroral guardar.");
                }
            });
    	});
    	
    })
</script>

</div>