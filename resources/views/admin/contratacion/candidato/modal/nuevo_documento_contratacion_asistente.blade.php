<div class="modal-header">
    <button aria-label="Close" class="close" data-dismiss="modal" type="button">
        <span aria-hidden="true">×</span>
    </button>

    <h4 class="modal-title"><b>Carga de documento</b></h4>
</div>

<div class="modal-body">
	{!! Form::model(Request::all(), ["id" => "fr_nuevo_documento_contratacion", "files" => true, "data-smk-icon" => "glyphicon glyphicon-remove"]) !!}
        <div class="modal-body">
            <input type="hidden" name="cand_id" id="cand_id" value="{{ $cand_id }}">
            <input type="hidden" name="req_id" id="req_id" value="{{ $req_id }}">

            <div class="col-md-12">
                <div class="form-group">
                    <label for="tipo_documento_id" class="control-label">Tipo documento *</label>
                    {!! Form::select("tipo_documento_id", $tipo_documento, null, [
                        "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                        "id" => "tipo_documento_id",
                        "required" => "required"
                    ]); !!}

                    <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("tipo_documento_id",$errors) !!}</p>
                </div>
            </div>

            <div class="col-md-12" style="display: none;" id="fecha_oculta">
                <div class="form-group">
                    <label for="fecha_afiliacion" class="control-label">Fecha Radicación:</label>
                    {!! Form::text("fecha_afiliacion",null,["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300","id"=>"fecha_afiliacion", "disabled" => "disabled"]); !!}

                    <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("fecha_afiliacion",$errors) !!}</p>
                </div>
            </div>
                 
            <div class="col-md-12">
                <div class="form-group">
                    <label for="archivo_documento" class="control-label">Archivo *</label>
                    {!! Form::file("archivo_documento[]", [
                        "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                        "accept" => ".doc,.docx,.pdf,.png,.jpg,.jpeg",
                        "multiple"=>"true",
                        "required" => "required"
                    ]); !!}

                    <p id="error_tipo" style="color: red;text-align: center;"></p>
                </div>
            </div>

            <div class="clearfix"></div>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-default | tri-px-2 tri-br-2 tri-border--none tri-transition-300" data-dismiss="modal">Cerrar</button>
            <button type="button" class="btn btn-success | tri-px-2 tri-br-2 tri-border--none tri-transition-300 tri-green"  id="guardar_nuevo_doc_contr">Guardar</button>
        </div>
    {!! Form::close() !!}

    <script>
        $(function(){
            $("#fecha_afiliacion").datepicker(confDatepicker);
             
            $("#tipo_documento_id").change(function(){
                if($(this).val()==13 || $(this).val()==14){
                    $("#fecha_oculta").show();
                    $("#fecha_oculta input").attr('disabled', null);
                }
                else{
                    $("#fecha_oculta").hide();
                    $("#fecha_oculta input").attr('disabled', 'disabled');
                }
            })

        	$("#guardar_nuevo_doc_contr").on("click", function(){
                if($('#fr_nuevo_documento_contratacion').smkValidate()){
                    
                    let formData = new FormData(document.getElementById("fr_nuevo_documento_contratacion"));
                    $.ajax({
                        url: "{{ route('admin.guardar_documento_asistente_contratacion') }}",
                        type: "post",
                        dataType: "html",
                        data: formData,
                        cache: false,
                        contentType: false,
                        processData: false,
                        beforeSend: function(){
                            $.smkAlert({
                                text: 'Guardando documento ...',
                                type: 'info'
                            })

                            setTimeout(() => {
                                $("#modal_peq").modal("hide")
                            }, 1000)
                        },
                        success: function(response) {
                            var res = JSON.parse(response);
                    
                            if(res.success) {
                                mensaje_success(res.mensaje);
                                setTimeout(() => {
                                    location.reload(true);
                                }, 2000)
                            }else{
                                mensaje_danger(res.mensaje);
                            }
                        },
                        error: function () {
                            $.smkAlert({
                                text: 'Ha ocurrido un error, intente nuevamente.',
                                type: 'danger'
                            })
                        }
                    })
                }
        	})
        })
    </script>
</div>