<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title">Soporte Aprobación Candidato</h4>
</div>

<div class="modal-body">
    <form id="fr_soporte_aprobacion" enctype="multipart/form-data">
        {!! Form::hidden("ref_id",(isset($orden)) ? $orden : '') !!}
        {!! Form::hidden("tipo",(isset($tipo)) ? $tipo : '') !!}

        <div class="col-md-12 form-group">
            <label for="archivo_soporte" class="col-md-4 control-label">Soporte Aprobación:<span class='text-danger sm-text-label'>*</span> </label>
            
            <div class="col-md-6">
                {!! Form::file("archivo_soporte",["class"=>"form-control","placeholder"=>"Soporte aprobación candidato","accept"=>".pdf,.jpg,.jpeg,.png", "required"=>"required"]) !!}
            </div>
            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("archivo_soporte",$errors) !!}</p>
        </div>

        <div class="col-md-12 form-group">
            <label for="resultado" class="col-md-4 control-label">Resultado:<span class='text-danger sm-text-label'>*</span> </label>
            <div class="col-md-6">
                {!! Form::select("resultado", [""=>"Seleccione",1=>"Apto",2=>"No apto",3=>"Pendiente"], null,["class"=>"form-control","id"=>"resultado", "required"=>"required"]) !!}
            </div>
        </div>

        <div class="col-md-12 form-group">
            <label for="observacion" class="col-md-4 control-label">Observación:<span class='text-danger sm-text-label'>*</span> </label>
            <div class="col-md-6">
                {!! Form::textarea("observacion",null,["class"=>"form-control","id"=>"textarea","rows"=>"4", "required"=>"required"]); !!}
            </div>
            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("observacion",$errors) !!}</p>
        </div>
    </form>

    <div class="clearfix"></div>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
    <button type="button" class="btn btn-success" id="guardar_soporte_aprobacion" >Guardar</button>
</div>