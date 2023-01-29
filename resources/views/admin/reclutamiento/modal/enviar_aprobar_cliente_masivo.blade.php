<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title">
        Enviar aprobación del cliente a:
        @foreach($datos_basicos as $candi)
            <small style="color: black;"><br><b>{{ mb_strtoupper($candi) }}</b></small>
        @endforeach
    </h4>
</div>

<div class="modal-body">
    {!! Form::open(["id" => "fr_apro_masi"]) !!}
        {!! Form::hidden("req_can_id", $req_can_id_j, ["id" => "candidato_req_fr"]) !!}
        {!! Form::hidden("req_id", $req_id->requerimiento_id, ["id" => "req_id"]) !!}

        ¿Desea enviar a estos candidatos a la aprobación del cliente?
        <br/>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label>Puede enviar email de notificación a usuarios asociados al cliente:</label>
                    {!! Form::select('usuario_cliente',$usuarios_clientes,null,['class'=>'form-control']) !!}
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
        @if(route("home") == "http://komatsu.t3rsc.co" || route("home") == "https://komatsu.t3rsc.co")
            <div class="col-md-12 form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">Observación:</label>

                <div class="col-sm-8">
                    {!! Form::textarea('observaciones', null, ['class' => 'form-control', 'rows' => 3]) !!}
                </div>

                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("observaciones", $errors) !!}</p>
            </div>
        @endif
    {!! Form::close() !!}

    <div class="clearfix"></div>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
    <button type="button" class="btn btn-success" id="confirmar_aprobar_cliente_masivo" >Confirmar</button>
</div>