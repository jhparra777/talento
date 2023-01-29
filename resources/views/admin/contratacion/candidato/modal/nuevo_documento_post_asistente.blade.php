<div class="modal-header">
    
    <button aria-label="Close" class="close" data-dismiss="modal" type="button">
        <span aria-hidden="true">×</span>
    </button>

    <h4 class="modal-title"><b>Carga de documento</b></h4>
</div>

<div class="modal-body">
	{!! Form::model(Request::all(),["id" => "fr_nuevo_documento_post", "files" => true, "data-smk-icon" => "glyphicon glyphicon-remove"]) !!}
        <div class="modal-body">
            <input type="hidden" name="cand_id" id="cand_id" value="{{$cand_id}}">
            <input type="hidden" name="req_id" id="req_id" value="{{$req_id}}">

            <div class="col-md-12">
                <div class="form-group">
                    <label for="tipo_documento_id" class="control-label" style="color: black;"> Tipo documento</label>

                    {!! Form::select("tipo_documento_id",$tipo_documento,null,["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", "required" => "required","id"=>"tipo_documento_id"]); !!}

                    <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("tipo_documento",$errors) !!}</p>
                </div>
            </div>

            <div class="col-md-12" id="section_fecha">
                <div class="form-group">
                    <label for="tipo_documento_id" class="control-label" style="color: black;"> Fecha finalización:</label>

                    {!! Form::text("fecha_finalizacion", null, [
                        "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                        "id" => "fecha_finalizacion",
                        "required" => "required"
                        ]);
                    !!}

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
                    <label for="observaciones" class="control-label" style="color: black;"> Observaciones</label>

                    {!! Form::textarea("observacion",null,["class"=>"form-control","id"=>"observaciones","rows"=>"3"]); !!}

                    <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("observaciones",$errors) !!}</p>
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
        $("#section_fecha").hide();
        $("#tipo_documento_id").change(function(){
            let id_document=$(this).val();
            $.ajax({
                    url: "{{route('admin.contratacion.verify_document')}}",
                    type: "post",
                    data: {
                        id_document: id_document
                    },
                    cache: false,
                   
                    success: function(response) {
                        
                    
                        if(response.success) {
                            $("#fecha_finalizacion").attr("required", true);
                            $("#section_fecha").show();
                        }else{
                            $("#fecha_finalizacion").removeAttr("required");
                            $("#section_fecha").hide();
                        }
                    },
                    error: function () {

                    }
                });

        });
    	$("#guardar_nuevo_doc").on("click", function(){
            if ($('#fr_nuevo_documento_post').smkValidate()) {

                var formData = new FormData(document.getElementById("fr_nuevo_documento_post"));

                $.ajax({
                    url: "{{route('admin.guardar_documento_asistente_post')}}",
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

        var confDatepicker2 = {
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
            yearRange: "1930:2050"
            //minDate:new Date()
        };
        $("#fecha_finalizacion").datepicker(confDatepicker2);
    	
    })
</script>

</div>