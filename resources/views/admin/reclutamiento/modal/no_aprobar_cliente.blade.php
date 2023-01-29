<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title">Rechazar candidato :<strong>#Req.{{$req_can->requerimiento_id}}</strong></h4>
        <h3>{{$candidato->nombres}} {{$candidato->primer_apellido}}</h3>
</div>
<div class="modal-body">
   {!! Form::model(Request::all(),["id"=>"fr_rechazar"]) !!}
    {!! Form::hidden("candidato_req",$req_can->id) !!}
    {{--{!! Form::hidden("candidato_req",null,["id"=>"candidato_req_fr"]) !!}--}}
    {!! Form::hidden("cliente_id",null) !!}

     <div class="col-md-12 form-group">
            <label for="inputEmail3" class="col-sm-4 control-label">Motivo de rechazo</label>
            <div class="col-sm-8">
                {!! Form::select ("motivo_rechazo",$motivos_rechazo,null,["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300"]); !!}
            </div>
            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("motivo_rechazo",$errors) !!}</p>
        </div>

    <div class="col-md-12 form-group">
            <label for="inputEmail3" class="col-sm-4 control-label"> Observaciones </label>
            <div class="col-sm-8">
               <textarea name="observaciones" class="form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300" rows="2">  </textarea>
            </div>
            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("observaciones",$errors) !!}</p>
     </div>
    

</div>

<div class="modal-footer">
    <button type="button" class="btn btn-default | tri-px-2 tri-br-2 tri-border--none tri-transition-300" data-dismiss="modal">Cerrar</button>

    <button type="button" class="btn btn-success | tri-px-2 tri-br-2 tri-border--none tri-transition-300 tri-green" id="confirmar_rechazo" >Confirmar</button>
</div>
 {!!Form::close()!!}
<script>
    $(function () {
        $("#fecha_fin_contrato, #fecha_inicio_contratos").datepicker(confDatepicker);
    });
</script>
