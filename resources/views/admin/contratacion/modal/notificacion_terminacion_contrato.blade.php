<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal"  aria-label="Close"><span aria-hidden="true">&times;</span></button>

  <div class="modal-title"> 
    <h5>Enviar Carta de Terminación de Contrato</h5>
    <h5>
        {{$candidato->nombres}} {{$candidato->primer_apellido}} {{$candidato->segundo_apellido}}
    </h5>
  </div>
</div>
<div class="modal-body">
    {!! Form::model(Request::all(),["id"=>"fr_envio_carta_terminacion_contrato"]) !!}
        {!! Form::hidden("contrato_id",$contrato_id,["id"=>"contrato_id"]) !!}
        <div class="row">
            <div class="col-md-12 mt-1">
                <label class="col-md-12">
                    <input type="checkbox" name="candidato" value="true"> Enviar al candidato
                </label>
            </div>

            <div class="col-md-12 mt-1">
                <label class="col-md-12" for="otro_destinatario">Añadir otros destinatarios (Correo electrónico)</label>
                <div class="col-md-12">
                    <input type="text" name="otros_destinatarios" id="otro_destinatario" class="form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300" placeholder="ejemplo@ejemplo.com,ejemplo22@otro.com">
                    <p class="help-block">Ingrese los correos electrónicos separados por comas (,).</p>
                </div>
            </div>
        </div>
    
    {!! Form::close() !!}
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default | tri-px-2 tri-br-2 tri-border--none tri-transition-300" data-dismiss="modal">Cerrar</button>

    <button type="button" class="btn btn-success | tri-px-2 tri-br-2 tri-border--none tri-transition-300 tri-green" id="enviar_carta_terminacion_contrato" >Enviar</button>

</div>

