<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title">Citar Candidato</h4>
</div>
<div class="modal-body">
    {!! Form::open(["class"=>"form-horizontal form-citacion", "role"=>"form", "id"=>"fr_citacion"]) !!}

        {!! Form::hidden("user_id",$usuario) !!}
        {!! Form::hidden("requerimiento",$requerimiento) !!}
        {!! Form::hidden("cliente",$cliente) !!}

        <div class="col-md-12 form-group">
            <label for="inputEmail3" class="col-sm-4 control-label"> Motivo Citación </label>
            <div class="col-sm-12">
                {!! Form::select("motivos",$motivos,null,["class"=>"form-control","id"=>"motivos"]); !!}
            </div>
            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("motivos",$errors) !!}</p>
        </div>

        <div class="col-md-12 form-group">
            <label for="inputEmail3" class="col-sm-4 control-label"> Descripción </label>
            <div class="col-sm-12">
                {!! Form::textarea("descripcion",null,["class"=>"form-control","id"=>"descripcion"]); !!}
            </div>
            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("descripcion",$errors) !!}</p>
        </div>

    {!! Form::close() !!}
   
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
    <button type="button" class="btn btn-success" id="guardar_cita" >Guardar</button>
</div>