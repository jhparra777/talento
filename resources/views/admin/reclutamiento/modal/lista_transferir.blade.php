{!! Form::open(["route"=>"admin.transferir_dato"]) !!}
    {!! Form::hidden("req_id", (!empty($req_id)) ? $req_id : '' )!!}
    
    <div class="modal-header alert-info">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title"><span class="fa fa-check-circle "></span> Confirmación</h4>
    </div>

    <div class="modal-body" id="texto">
        <ul>
            @if(!empty(($errores_array)))
                @if(is_array($errores_array))
                    {!! implode(" ", $errores_array) !!}
                @endif
            @endif
        </ul>

        @if(!empty(($errores_array_req)))
            @if(is_array($errores_array_req) && count($errores_array_req)>0)
                <p>Seleccione los candidatos que desea transferir a este requerimiento.</p>
                <ul>{!! implode(" ", $errores_array_req) !!}</ul>
            @endif
        @endif
    </div>

    <div class="modal-footer">
        @if(!empty($errores_array_req))
            @if(is_array($errores_array_req) && count($errores_array_req)>0)
                Transferir con trazabilidad
                {!! Form::checkbox("trazabilidad", 1, false) !!}

                <button type="submit" class="btn btn-warning" >Transferir</button>
            @endif
        @endif
        
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
    </div>
{!! Form::close() !!}