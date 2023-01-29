<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title">Hacer visita domiciliaria a : <strong>{{$candidato->nombres." ".$candidato->primer_apellido." ".$candidato->segundo_apellido}}</strong> </h4>
</div>
<div class="modal-body">
    {!! Form::open(["id"=>"fr_visita"]) !!}
    {!! Form::hidden("user_id",$candidato->user_id,["id"=>"user_id"]) !!}
    {!! Form::hidden("candidato_req",$candidato->req_candidato,["id"=>"candidato_req_fr"]) !!}
    <div class="col-md-12 form-group">
            <label for="entidad_eps" class="col-sm-4 control-label">Clase de visita:</label>
                
            <div class="col-sm-8">
                {!! Form::select("clase_visita", $tipo_visita, null, ["class" => "form-control selectcategory", "id" => "clase_visita"]) !!}
            </div>
                
            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("clase_visita", $errors) !!}</p>
    </div>
    
    {!! Form::close() !!}


    <div class="clearfix"></div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
    <button type="button" class="btn btn-success" id="confirmar_envio_visita_docimiciliaria" >Confirmar</button>
</div>
