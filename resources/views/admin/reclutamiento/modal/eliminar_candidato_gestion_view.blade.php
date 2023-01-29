<?php
     if ($candidato_fuente->candidato_id != -1) {
          $candidato = $candidato_fuente->datos_basicos;
     } else {
          $candidato = (object) ['nombres' => $candidato_fuente->nombres, 'primer_apellido' => ''];
     }
?>
<div class="modal-header">
     <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
     <?php
          $texto_modulo = ($modulo != 'otras fuentes' ? $modulo.'/a al ' : 'en '.$modulo.' del ');
     ?>
     <h4 class="modal-title">Confirma que deseas eliminar el candidato <b>{{ $candidato->nombres . ' ' . $candidato->primer_apellido }}</b> {{ $texto_modulo }} Req. #{{ $candidato_fuente->requerimiento_id }}</h4>
</div>

<div class="modal-body">
     {!! Form::open(["id" => "frm_eliminar_candidato_gestion"]) !!}
          {{ csrf_field() }}

          <input type="hidden" value="{{ $candidato_fuente->id_registro }}" id="id_registro_eliminar_gestion">
          <input type="hidden" value="{{ $modulo }}" id="modulo_eliminar_gestion">
          <input type="hidden" value="{{ $candidato_fuente->requerimiento_id }}" id="req_id_eliminar_gestion">
          <input type="hidden" value="{{ $candidato_fuente->candidato_id }}" id="candidato_id_eliminar_gestion">

          <div class="col-md-12 form-group">
               <label for="motivo_descarte_id" class="control-label"> Motivo de descarte * </label>
               {!! Form::select('motivo_descarte_id',$motivos_descarte, null,['class'=>'form-control', 'id' => 'motivo_descarte_id', 'required' => 'required']) !!}
               <p class="error text-danger direction-botones-center" style="{{ ($errors->has('motivo_descarte_id') ? '' : 'display: none;') }}">
                    {!! FuncionesGlobales::getErrorData("motivo_descarte_id", $errors) !!}
               </p>
          </div>

          <div class="col-md-12 form-group">
               <label for="observacion" class="control-label"> Observación * </label>
               {!! Form::textarea('observacion',null,['class'=>'form-control', 'rows' => 3, 'id' => 'observacion_eliminar_gestion', 'placeholder' => 'Ingrese una observación', 'required' => 'required']) !!}
               <p class="error text-danger direction-botones-center" style="{{ ($errors->has('observacion') ? '' : 'display: none;') }}">
                    {!! FuncionesGlobales::getErrorData("observacion", $errors) !!}
               </p>
          </div>
     {!! Form::close() !!}
     <div class="clearfix"></div>
</div>
<div class="modal-footer">  
     <button type="button" class="btn btn-default" data-dismiss="modal"> Cancelar </button>
     <button type="button" class="btn btn-warning" id="confirmar_eliminar_candidato_gestion"> Confirmar </button>
</div>