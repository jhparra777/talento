<div class="modal-header">

    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

    @if(route("home")!="http://komatsu.t3rsc.co" && route("home")!="https://komatsu.t3rsc.co")
        
        <h4 class="modal-title">Realizar validación documentos  : 

    @else
         <h4 class="modal-title">Realizar estudio de seguridad  : 

    @endif
    
    @foreach($datos_basicos as $candi)
        
        <strong><br>{{mb_strtoupper($candi)}}</strong>

    @endforeach 

        </h4>
</div>

<div class="modal-body">
    {!! Form::open(["id"=>"fr_docu_masi"]) !!}
        
        {!! Form::hidden("req_can_id",$req_can_id_j,["id"=>"candidato_req_fr"]) !!}
            
        @if(route("home") != "http://komatsu.t3rsc.co" && route("home") != "https://komatsu.t3rsc.co")
            
            ¿ Desea enviar a estos candidatos a validar documentos ?

        @else

            ¿ Desea enviar a estos candidatos a estudio de seguridad ?

        @endif

    {!! Form::close() !!}

    <div class="clearfix"></div>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
    <button type="button" class="btn btn-success" id="confirmar_documentos_masivo" >Confirmar</button>
</div>
