<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title">Candidato  : <strong>{{$candidato->nombres." ".$candidato->primer_apellido." ".$candidato->segundo_apellido}}</strong> </h4>
</div>
<div class="modal-body">
    {!! Form::open(["id"=>"fr_pruebas"]) !!}
    {!! Form::hidden("candidato_req",$candidato->req_candidato,["id"=>"candidato_req_fr"]) !!}
    
    @if(route("home") == "http://komatsu.t3rsc.co" || route("home") == "https://komatsu.t3rsc.co")
    	¿ Desea enviar a aprobar a este candidato ?

        <div class="col-md-12 form-group">
         <label for="inputEmail3" class="col-sm-2 control-label"> Observación: </label>
          <div class="col-sm-8">
          {!! Form::textarea('observaciones',null,['class'=>'form-control', 'rows' => 3]) !!}
          </div>
          <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("observaciones",$errors) !!}</p>
        </div>
    @else
      <h4>¿Desea enviar a realizar la aprobación por parte del cliente a este candidato?</h4>
      <br/>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label>Puede enviar email de notificación a usuarios asociados al cliente:</label>
                    {!! Form::select('usuarios_clientes',$usuarios_clientes,null,['class'=>'form-control']) !!}
                </div>
            </div>
			<div class="col-md-12">
				<div class="form-group">
					<label for="otro_destinatario">Añadir otros destinatarios (Correo electrónico):</label>
					<input type="text" name="otros_destinatarios" id="otro_destinatario" class="form-control" placeholder="ejemplo@ejemplo.com,ejemplo22@otro.com">
					<p class="help-block">Ingresa los correos electrónicos.</p>
				</div>
			</div>
		</div>
    @endif

    {!! Form::close() !!}
    <div class="clearfix"></div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
    <button type="button" class="btn btn-success" id="confirmar_aprobar_cliente" >Confirmar</button>
</div>
