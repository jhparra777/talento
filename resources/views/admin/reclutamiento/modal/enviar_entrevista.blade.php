<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title">Realizar entrevista a : <strong>{{$candidato->nombres." ".$candidato->primer_apellido." ".$candidato->segundo_apellido}}</strong> </h4>
</div>
<div class="modal-body">
    {!! Form::open(["id"=>"fr_pruebas"]) !!}
    {!! Form::hidden("candidato_req",$candidato->req_candidato,["id"=>"candidato_req_fr"]) !!}
    @if(route("home")=="http://komatsu.t3rsc.co"  || route("home")=="https://komatsu.t3rsc.co")
    	<div class="col-md-6 form-group">
            <label class="col-sm-12 pull-left" for="inputEmail3">
                Tipo Entrevista
            </label>
            <div class="col-sm-12">
                {!! Form::select ("tipo_entrevista",$tipo_entrevista,["class"=>"form-control"]); !!}
            </div>
        </div>
	   
	@endif
	    Desea enviar a realizar la entrevista a este candidato?
    {!! Form::close() !!}


    <div class="clearfix"></div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-success" id="realizar_entrevista" >Realizar Entrevista</button>
    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
</div>

