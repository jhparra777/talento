<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

    <h4 class="modal-title">
        Enviar a exámenes médicos a : <strong>{{ $candidato->nombres." ".$candidato->primer_apellido." ".$candidato->segundo_apellido }}</strong>
    </h4>
</div>

<div class="modal-body">
    {!! Form::model(Request::all(), ["id" => "fr_enviar_examen","data-smk-icon"=>"fa fa-times-circle"]) !!}
        {!! Form::hidden("candidato_req", $candidato->req_candidato, ["id" => "candidato_req_fr"]) !!}
        {!! Form::hidden("cliente_id", null, ["id" => ""]) !!}
        {!! Form::hidden("lleva_ordenes", $lleva_ordenes, ["id" => "lleva_ordenes"]) !!}

        @if($lleva_ordenes == 'si')

            <p class="alert alert-warning">
                El Candidato seleccionado pasará a ser gestionado por el proceso de Exámenes Médicos
                <strong>¿Desea continuar?</strong>
            </p>

            <div class="col-md-12 form-group">
                <label for="proveedor" class="col-sm-3 control-label">Proveedor de examenes:</label>

                <div class="col-sm-9">
                    {!! Form::select("proveedor", $proveedores, null, ["class" => "form-control", "id" => "proveedor","required" => "required","data-smk-msg"=>"Debe seleccionar un laboratorio"]); !!}
                </div>

                <p id="proveedor_med_text" style="display: none;" class="error text-danger direction-botones-center">Selecciona proveedor</p>
            </div>

            <label for="examen" class="col-sm-3 control-label">Examenes a realizar: </label>

            <div class="col-md-12 form-group">
                <div class="row">
                    @foreach($examenes as $examen)
                        <div class="col-sm-6">
                            @if( $examen->hasCargo($cargo_especifico) )
                                <p>{!! Form::checkbox("examen[]",$examen->id,true,["class"=>"examen"]) !!}{{$examen->nombre}}</p>
                            @else
                                <p>{!! Form::checkbox("examen[]",$examen->id,false,["class"=>"examen"]) !!}{{$examen->nombre}}</p>
                            @endif
                        </div>
                    @endforeach
               </div>
            </div>

            <div class="col-md-12 form-group">
             <label for="observacion" class="col-sm-3 control-label">Otros:</label>
               
               <div class="col-sm-9">
                {!! Form::textarea("observacion",null, ["class" => "form-control", "id" => "observacion","data-smk-msg"=>"Escriba observación"]); !!}
               </div>

            </div>

        @else
            Desea enviar a este candidato a exámenes médicos.
        @endif
    {!! Form::close() !!}
    <div class="clearfix"></div>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
    <button type="button" class="btn btn-success" id="guardar_examen" >Enviar</button>
</div>

<script>
    $(function(){
        $("#fecha_inicio").datepicker(confDatepicker);
        $("#fecha_fin").datepicker(confDatepicker);
    });
</script>