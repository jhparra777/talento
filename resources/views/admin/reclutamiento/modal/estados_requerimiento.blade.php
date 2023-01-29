<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    
    <h4 class="modal-title"><b>Cambiar Estado requerimiento</b></h4>
    <h5>
        <strong>Requerimiento</strong> {{$req_id}}
    </h5>
</div>

<div class="modal-body">
    <div class="col-md-12 form-group">
        <label for="inputEmail3" class="col-sm-12 control-label"> Estado Requerimiento <span class="text-danger">*</span></label>
        
        <div class="col-sm-12">
         {!! Form::hidden("req_id",$req_id,(["id"=>"req_id"])) !!}
         {!! Form::select("estado_requerimiento",$estado,old('estado_requerimiento'),["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300","id"=>"estado_terminacion"]); !!}
         <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("estado_requerimiento",$errors) !!}</p>
        </div>

        
    </div>

    <div class="col-md-12 form-group">
            <label for="inputEmail3" class="col-sm-12 control-label"> Motivo <span class="text-danger">*</span></label>

        @if(route('home') =="http://komatsu.t3rsc.co" || route('home') == "http://demo.t3rsc.co") 
            <div class="col-sm-12">
                {!! Form::text("motivo_cancelacion",null,["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300","placeholder"=>"Motivo","id"=>"motivo_cancelacion"]); !!}
            
                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("motivo_cancelacion",$errors) !!}</p>
            </div>
        @else
            <div class="col-sm-12">
                {!! Form::select("motivo_cancelacion",$motivos,old('motivo_cancelacion'),["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300","id"=>"motivo_cancelacion"]); !!}
                
                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("motivo_cancelacion",$errors) !!}</p>
            </div>
        @endif

    </div>

    <div class="col-md-12 form-group">
        <label for="inputEmail3" class="col-sm-12 control-label"> Observaciones <span class="text-danger">*</span></label>
        
        <div class="col-sm-12">
            {!! Form::textarea("observaciones_terminacion",null,["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300","id"=>"observaciones_terminacion"]); !!}
            
            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("observaciones_terminacion",$errors) !!}</p>
        </div>

    </div>

    <div class="clearfix"></div>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-default | tri-px-2 tri-br-2 tri-border--none tri-transition-300" data-dismiss="modal">Cerrar</button>
    <button type="button" class="btn btn-danger | tri-px-2 tri-br-2 tri-border--none tri-transition-300 tri-red" id="terminar_requerimiento" >Cambiar estado requerimiento</button>
</div>