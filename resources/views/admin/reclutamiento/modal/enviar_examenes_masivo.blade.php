<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <h4 class="modal-title">Enviar a Exámenes: 
    
    @foreach($datos_basicos as $candi)
      <strong><br>{{mb_strtoupper($candi)}}</strong>
    @endforeach 
  </h4>
</div>
<div class="modal-body">
    {!! Form::open(["id"=>"fr_exam_masi"]) !!}
    {!! Form::hidden("req_can_id",$req_can_id_j,["id"=>"candidato_req_fr"]) !!}
    {!! Form::hidden("lleva_ordenes", $lleva_ordenes, ["id" => "lleva_ordenes"]) !!}

    {{--
    @if(route("home")!="http://komatsu.t3rsc.co" && route("home")!="https://komatsu.t3rsc.co" && route("home")!="https://vym.t3rsc.co" && route("home")!="https://listos.t3rsc.co")
    
        <p class="alert alert-warning">
           los Candidatos seleccionado pasarán a ser gestionado por el proceso de Exámenes Médicos
        </p>

        <div class="col-md-12 form-group">
          <label for="inputEmail3" class="col-sm-3 control-label">Fecha Ingreso</label>
           <div class="col-sm-9">
            {!! Form::text("fecha_inicio",null,["class"=>"form-control","id"=>"fecha_inicio" ]); !!}
           </div>
         <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("fecha_inicio",$errors) !!}</p>
        </div>

        <div class="col-md-12 form-group">
          <label for="inputEmail3" class="col-sm-3 control-label">Fecha Retiro</label>
            <div class="col-sm-9">
            {!! Form::text("fecha_fin",null,["class"=>"form-control","id"=>"fecha_fin" ]); !!}
            </div>
            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("fecha_fin",$errors) !!}</p>
        </div>

        <div class="col-md-12 form-group">
          <label for="inputEmail3" class="col-sm-3 control-label">Observaciones</label>
            <div class="col-sm-9">
             {!!Form::textarea("observaciones",null,["class"=>"form-control" ]);!!}
            </div>
            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("observaciones",$errors) !!}</p>
        </div>

        <div class="col-md-12 form-group">
          <label for="inputEmail3" class="col-sm-3 control-label">Quién autorizó por parte del cliente* </label>
           <div class="col-sm-9">
            {!! Form::select("user_autorizacion",$usuarios_cliente,null,["class"=>"form-control" ]); !!}
           </div>
         <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("user_autorizacion",$errors) !!}</p>
        </div>


    @endif
    --}}


    @if($lleva_ordenes == 'si')

      <div class="col-md-12 form-group">
        <label for="proveedor" class="col-sm-3 control-label">Proveedor de exámenes:</label>

        <div class="col-sm-9">
            {!! Form::select("proveedor", $proveedores, null, ["class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", "id" => "proveedor","required" => "required","data-smk-msg"=>"Debe seleccionar un laboratorio"]); !!}
        </div>

        <p id="proveedor_med_text" style="display: none;" class="error text-danger direction-botones-center">Selecciona proveedor</p>
      </div>

      <label for="examen" class="col-sm-3 control-label">Exámenes a realizar: </label>

      <div class="col-md-12 form-group">
        <div class="row">
          @foreach($examenes as $examen)
            <div class="col-sm-6">
              @if( $cargo_especifico != null && $cargo_especifico != "-1"  && $cargo_especifico != "" )
                @if( in_array($examen->id,$cargo_especifico->examenes->pluck("id")->toArray()) )
                  <p>{!! Form::checkbox("examen[]",$examen->id,true,["class"=>"examen"]) !!}{{$examen->nombre}}</p>
                @else
                  <p>{!! Form::checkbox("examen[]",$examen->id,false,["class"=>"examen"]) !!}{{$examen->nombre}}</p>
                @endif
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
          {!! Form::textarea("observacion",null, ["class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", "id" => "observacion","data-smk-msg"=>"Escriba observación"]); !!}
        </div>
      </div>

    @else
        ¿Desea enviar a estos candidatos a exámenes médicos?
    @endif

    {!! Form::close() !!}

    <div class="clearfix"></div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default | tri-px-2 tri-br-2 tri-border--none tri-transition-300" data-dismiss="modal">Cerrar</button>
    <button type="button" class="btn btn-success | tri-px-2 tri-br-2 tri-border--none tri-transition-300 tri-green" id="confirmar_examenes_masivo" >Confirmar</button>
</div>
