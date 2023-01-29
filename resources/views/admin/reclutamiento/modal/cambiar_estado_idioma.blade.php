<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title">Cambiar estado</h4>
</div>

<div class="modal-body">

    {!! Form::model(Request::all(),["id"=>"fr_cambio_estado_idioma"]) !!}
        
        {!! Form::hidden("ref_id") !!}
        {!! Form::hidden("estado") !!}

        {!! Form::hidden("modulo",$datos->get("modulo")) !!}
        {!! Form::hidden("tipo",$datos->get("tipo")) !!}
    
        @if($respuestas !=0 )
            <div class="col-md-12" id="mensaje-resultado">
                <div class="alert alert-warning alert-dismissible" role="alert">
                    <p>El puntaje de la respuesta mas bajo es 1 y el mas alto es el 5</p>
                </div>
            </div>
        @endif

        <div class="col-md-12 form-group">
            <label for="inputEmail3" class="col-sm-4 control-label"> Estado</label>

            <div class="col-sm-8">
                @if(route("home") == "http://komatsu.t3rsc.co" || route("home") == "https://komatsu.t3rsc.co" || route("home") == "http://desarrollo.t3rsc.co")
                    {!! Form::select("estado_ref",[""=>"Seleccionar","1"=>"Apto","2"=>"No apto","3"=>"Tentativo"],null,["class"=>"form-control estado_ref"]); !!}
                @else
                    {!! Form::select("estado_ref",[""=>"Seleccionar","1"=>"Apto","2"=>"No apto","3"=>"Pendiente"],null,["class"=>"form-control estado_ref"]); !!}
                @endif
            </div>

            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("estado_ref",$errors) !!}</p>
        </div>

        @if($respuestas != 0)
            <div class="col-md-12 form-group puntaje">
                <label for="inputEmail3" class="col-sm-4 control-label">Puntaje</label>
                <div class="col-sm-8">
                    {!! Form::select("puntaje",[""=>"Seleccionar","1"=>"1","2"=>"2","3"=>"3","4"=>"4","5"=>"5"],null,["class"=>"form-control puntaje"]); !!}
                    {!! Form::hidden("respuesta_id", $respuesta->id) !!}
                </div>
                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("estado_ref",$errors) !!}</p>
            </div>
        @endif
    
        <div class="col-md-12 form-group motivo">
            <label for="inputEmail3" class="col-sm-4 control-label"> Motivo Rechazo</label>

            <div class="col-sm-8">
                {!! Form::select("motivo_rechazo_id",$motivos,null,["class"=>"form-control "]); !!}
            </div>

            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("motivo_rechazo_id",$errors) !!}</p>
        </div>

        <div class="col-md-12 form-group">
            <label for="inputEmail3" class="col-sm-4 control-label"> Observaciones</label>

            <div class="col-sm-12">
                {!! Form::textarea("observaciones",null,["class"=>"form-control"]); !!}
            </div>
        </div>

        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("observaciones",$errors) !!}</p>

    {!! Form::close() !!}

    <div class="clearfix"></div>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
    <button type="button" class="btn btn-success" id="guardar_estado_idioma" >Guardar</button>
</div>

<script>
    $(function(){
        if ("{{$datos->pregunta_id}}" == "") {
            $('.puntaje').hide();      
        }

        $('.motivo').hide();
      
        $('.estado_ref').change(function(){
            if( $('.estado_ref').val() == 2 ){
                $('.motivo').show();
            }
            else{
                $('.motivo').hide();
            }
        })
    });
</script>