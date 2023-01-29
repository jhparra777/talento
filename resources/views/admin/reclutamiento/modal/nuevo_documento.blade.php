<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title">Documentos</h4>
</div>

<div class="modal-body">
    <form id="fr_documento_verificado" enctype="multipart/form-data">
        {!! Form::hidden("ref_id",(isset($orden)) ? $orden : '') !!}
        {!! Form::hidden("tipo",(isset($tipo)) ? $tipo : '') !!}

        <div class="col-md-12 form-group">
            <label for="tipo_documento" class="col-md-4 control-label">Tipo Documento:<span class='text-danger sm-text-label'>*</span></label>
            <div class="col-md-6"> 
                {!! Form::select("tipo_documento_id",$tipoDocumento,$campos['tipo_documento_id'],["class"=>"form-control","id"=>"tipo_documento"]) !!}  
            </div>
        </div>
        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("tipo_documento_id",$errors) !!}</p>

        <div class="col-md-12 form-group">
            <label for="archivo_documento" class="col-md-4 control-label">Archivo Documento:<span class='text-danger sm-text-label'>*</span> </label>
            
            <div class="col-md-6">
                {!! Form::file("archivo_documento",["class"=>"form-control","placeholder"=>"Archivo Documento","accept"=>".pdf,.jpg,.jpeg,.png"]) !!}
            </div>
        </div>
        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("archivo_documento",$errors) !!}</p>

            <div class="col-md-12 form-group">
                <label for="resultado" class="col-md-4 control-label">Resultado:<span class='text-danger sm-text-label'>*</span> </label>
                <div class="col-md-6">
                    {!! Form::select("resultado", [""=>"Seleccione",1=>"Apto", 2=>"No apto"], null,["class"=>"form-control","id"=>"resultado"]) !!}
                </div>
            </div>
            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("resultado",$errors) !!}</p>

            <div class="col-md-12 form-group">
                <label for="obrservacion" class="col-md-4 control-label">Observación:<span class='text-danger sm-text-label'>*</span> </label>
                <div class="col-md-6">
                    {!! Form::textarea("observacion",$campos['observacion'],["class"=>"form-control","id"=>"observacion","rows"=>"4"]); !!}
                </div>
            </div>
            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("observacion",$errors) !!}</p>

        <div class="col-md-12 form-group fecha_vencimiento">
            <label for="fecha_vencimiento" class="col-md-4 control-label">Fecha Vencimiento:</label>
            
            <div class="col-md-6">
                {!! Form::text("fecha_vencimiento",$campos['fecha_vencimiento'],["class"=>"form-control","id"=>"fecha_vencimiento","placeholder"=>"Fecha Vencimiento", "readonly" => "readonly"]) !!}
            </div>
        </div>
        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("fecha_vencimiento",$errors) !!}</p>
    </form>

    <div class="clearfix"></div>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
    <button type="button" class="btn btn-success" id="guardar_documento_verificado" >Guardar</button>
</div>

<script>
    $(function () {
        $("#fecha_vencimiento").datepicker(confDatepicker);
        //$('.fecha_vencimiento').hide();

        $('.documento_vence').change(function(){
            if($(this).prop('checked')){
                $('.fecha_vencimiento').show();
            }else{
                $('.fecha_vencimiento').hide();
               
            }
        })
    });
</script>