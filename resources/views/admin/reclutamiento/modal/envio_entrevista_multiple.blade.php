<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

    <h4 class="modal-title">
    @if(count($candidatos) > 0)
        @if(count($candidatos) > 1)
            <h5><strong>¿Enviar a entrevista múltiple a estos {{ count($candidatos) }} candidatos?</strong></h5> 
        @else
            <h5><strong>¿Enviar a entrevista múltiple a este candidato?</strong></h5>
        @endif
        @foreach ($candidatos as $key => $candidato)
            <strong>{{ $candidato->numero_id." ".$candidato->nombres." ".$candidato->primer_apellido }}</strong>
            @if($key%2)
                <br>
            @else
                 ,
            @endif
        @endforeach
    @endif
    </h4>
</div>

<div class="modal-body">
    @if(count($candidatos) > 0)
        {!! Form::model(Request::all(), ["id" => "fr_entrevista_multiple"]) !!}
            {!! Form::hidden("candidato_req", $req_can_ids, ["id" => "candidato_req"]) !!}

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="titulo" class="col-sm-4 control-label"> Título: </label>
                        <div class="col-sm-8">
                            {!! Form::text('titulo',null,['class'=>'form-control', 'required' => 'required', 'placeholder' => 'Escriba un título para la entrevista múltiple']) !!}
                        </div>
                        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("titulo",$errors) !!}</p>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label for="descripcion" class="col-sm-4 control-label"> Descripción: </label>
                        <div class="col-sm-8">
                            {!! Form::textarea('descripcion', null, ['class' => 'form-control', 'maxlength' => 250, 'rows' => 3, 'placeholder' => 'Puede agregar una descripción para la entrevista múltiple. Máximo 250 caracteres']) !!}
                        </div>
                        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("descripcion",$errors) !!}</p>
                    </div>
                </div>
            </div>
        {!! Form::close() !!}
    @endif
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
    @if(count($candidatos) > 0)
        <button type="button" class="btn btn-success" id="confirmar_entrevista_multiple" >Enviar</button>
    @endif
</div>