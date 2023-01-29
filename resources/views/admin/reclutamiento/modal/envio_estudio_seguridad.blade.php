<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title">Enviar a estudios de seguridad a : <strong>{{ $candidato->nombres." ".$candidato->primer_apellido." ".$candidato->segundo_apellido }}</strong> </h4>
</div>

<div class="modal-body">
    {!! Form::model(Request::all(), ["id" => "fr_enviar_estudio_seg"]) !!}
        {!! Form::hidden("candidato_req", $candidato->req_candidato, ["id" => "candidato_req_fr"]) !!}
        {!! Form::hidden("cliente_id", null, ["id" => ""]) !!}

        @if(1==2)
            <p class="alert alert-warning">
                El Candidato seleccionado pasará a ser gestionado por el proceso de Estudios de Seguridad
                <strong>¿ Desea continuar ?</strong>
            </p>

            <div class="col-md-12 form-group">
                <label for="inputEmail3" class="col-sm-3 control-label">Proveedor de estudios:</label>

                <div class="col-sm-9">
                    {!! Form::select("proveedor", $proveedores, null, ["class" => "form-control", "id" => "proveedor_seg" ]); !!}
                </div>

                <p id="proveedor_seg_text" style="display: none;" class="error text-danger direction-botones-center">Selecciona proveedor</p>
            </div>

            <label for="inputEmail3" class="col-sm-3 control-label">Estudios a realizar: </label>

            <div class="col-md-12 form-group">                
                @foreach($examenes as $examen)
                    @if($examen->cargo == $cargo_especifico)
                        <p>{!! Form::checkbox("estudio_seg[]", $examen->id, true, ["class" => "estudio_seg"]) !!} {{ $examen->nombre }}</p>
                    @else   
                        <p>{!! Form::checkbox("estudio_seg[]", $examen->id, false, ["class" => "estudio_seg"]) !!} {{ $examen->nombre }}</p>
                    @endif
                @endforeach
            </div>
    {!! Form::close() !!}
        @else
            Desea enviar a este candidato a estudios de seguridad.
        @endif
        
        <div class="clearfix"></div>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
    <button type="button" class="btn btn-success" id="guardar_estudio_seguridad">Enviar</button>
</div>