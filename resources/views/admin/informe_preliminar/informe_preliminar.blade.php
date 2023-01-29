<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title">
    @if(route("home")=="https://gpc.t3rsc.co")
        ENTREVISTA BEI
    @else
         Informe Preliminar
    @endif
   
    </h4>
</div>
<div class="modal-body">
    {!! Form::open(["class"=>"form-horizontal", "role"=>"form", "id"=>"fr_preliminar"]) !!}

        {!! Form::hidden("user_id",$usuario) !!}
        {!! Form::hidden("requerimiento",$requerimiento) !!}
        {!! Form::hidden("cliente",$cliente) !!}

        @if($RequerimientoCompetencias->count() >= 1)
            <div class="col-md-6">
                <h3>COMPETENCIAS</h3>
            </div> 
            <div class="col-md-3">
                <h3>IDEAL</h3>
            </div> 
            <div class="col-md-3">
                <h3>PUNTUACIÓN</h3>
            </div> 
            @foreach($RequerimientoCompetencias as $item)
                {!! Form::hidden("id_preliminar[$item->competencia_id]", null,["class"=>"id_preliminar"]) !!}
                <div class="col-md-6 form-group">
                    {{ $item->competencia_nombre }}
                </div>
                <div class="col-md-3">
                    {{ $item->ideal}}

                    {{--@if($item->puntuacion == 0)
                        BAJO
                    @endif
                     @if($item->puntuacion == 10)
                        MEDIO
                    @endif
                     @if($item->puntuacion == 20)
                        ALTO
                    @endif--}}
                    
                </div>
                <div class="col-md-3 form-group">
                    <div class="col-sm-12">
                        {!! Form::select("criterio[$item->competencia_id]",$criterio,null,["class"=>"form-control criterio"]); !!}
                    </div>
                </div>
            @endforeach
        @endif
        <div class="col-md-12 form-group">
            {!! Form::textarea("descripcion_candidato", $descripcion, ["class"=>"form-control","placeholder"=>"Descripción del candidato."]) !!}
        </div>

    {!! Form::close() !!}
   
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
    @if($valida_boton == "false")
        <button type="button" class="btn btn-success" id="guardar_preliminar">Guardar</button>
    @else
        <button type="button" class="btn btn-success" id="actualizar_preliminar">Actualizar</button>
    @endif
</div>