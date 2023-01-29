<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title">Resultado Estudio Seguridad</h4>
</div>
<div class="modal-body">

   {!! Form::model(Request::all(),["id"=>"fr_documento_verificado_seguridad"]) !!}
        
        {!! Form::hidden("ref_id") !!}
        {!! Form::hidden("tipo",$tipo) !!}
        {!! Form::hidden("orden",$orden)  !!}

        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("tipo_documento_id",$errors) !!}</p>

        <div class="col-md-12 form-group">
            <label for="archivo_documento" class="col-md-4 control-label">Archivo Documento:<span class='text-danger sm-text-label'>*</span> </label>
            <div class="col-md-6">
                {!! Form::file("archivo_documento",["class"=>"form-control","placeholder"=>"Archivo Documento"]) !!}
            </div>
        </div>

        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("archivo_documento",$errors) !!}</p>

        <div class="col-md-12 form-group">
            <label for="resultado" class="col-md-4 control-label">Resultado:<span class='text-danger sm-text-label'>*</span> </label>
            <div class="col-md-6">
                {!! Form::select("resultado", [""=>"Seleccione",1=>"Apto",2=>"No apto"], null,["class"=>"form-control","id"=>"area_id"]) !!}
            </div>
        </div>

        <div class="col-md-12 form-group">
            <label for="obrservacion" class="col-md-4 control-label">Observación:<span class='text-danger sm-text-label'>*</span> </label>
            <div class="col-md-6">
              {!! Form::textarea("observacion",null,["class"=>"form-control","id"=>"textarea","rows"=>"4"]); !!}
            </div>
        </div>

        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("descripcion_archivo",$errors) !!}</p>
        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("fecha_vencimiento",$errors) !!}</p>

    {!! Form::close() !!}

    <div class="clearfix"></div>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
    <button type="button" class="btn btn-success" id="guardar_estudio_seguridad" >Guardar</button>
</div>

<script>
    $(function () {
        $("#fecha_vencimiento").datepicker(confDatepicker);
         $('.fecha_vencimiento').hide();

          $('.documento_vence').change(function(){
            if($(this).prop('checked')){
                $('.fecha_vencimiento').show();
            }else{
                $('.fecha_vencimiento').hide();
               
            }
  
        })
    });
</script>