<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <h4 class="modal-title">Gestionar referencia</h4>
 </div>

 <div class="modal-body">
    {!! Form::model((!empty($referencia_estudio))?$referencia_estudio:Request::all(),["id"=>"fr_referencia"]) !!}
    {!! Form::hidden("ref_id",null,["id"=>"ref_id"])!!}
    {!! Form::hidden("estudios_id",$estudio->id) !!}
     @if(!empty($referencia_estudio))
      {!! Form::hidden("verificada_id",$referencia_estudio->id) !!}
     @endif
     <hr>
    <h4 class="titulo1"><b>Informacion suministrada por el candidato</b></h4>
    <hr>
    <table class="table table-bordered tbl_info" style="margin-bottom: 0px">
       <tr>
        <th> Institución </th>
        <td>{{$estudio->institucion}}</td>
        <th> Nivel estudios </th>
        <td>{{$estudio->nivel}}</td>
       </tr>
       <tr>
        <th>Título obtenido</th>
        <td>{{$estudio->titulo_obtenido}}</td>
        <th>Periodos cursados</th>
        <td>{{$estudio->semestres_cursados}} {{$estudio->periodo}}</td>
       </tr>
       <tr>
         <th>Ciudad</th>
         <td>{{$estudio->ciudad}}</td>
            <th>Estudio Actual</th>
            <td>
                @if( $estudio->estudio_actual == 1 )
                    Si
                @else
                    No
                @endif
            </td>
        </tr>
        @if( $estudio->estudio_actual != 1 )
          <tr>
            <th>Fecha finalización</th>
            <td colspan="3">
                {{$estudio->fecha_finalizacion}}
            </td>
          </tr>
        @endif
        @if( $estudio->certificados->count() > 0 )
        <tr>
          <th>
            Documentos adjuntos
          </th>

          <td colspan="3">
            <ul>
                @foreach( $estudio->certificados as $i => $certificado)
                  <li>
                      <a class="" title="Ver" target="_blank" href='{{route("view_document_url", encrypt("recursos_documentos/"."|".$certificado->documento->nombre_archivo))}}' style="color: green;">
                        
                        Ver certificado {{$i+1}}
                      </a>
                  </li>
                @endforeach
            </ul>
          </td>
        </tr>
        @else
        <tr>
          <th>
            Documentos adjuntos
          </th>
          <td colspan="3">
            No ha cargado documentos certificados
          </td>
        </tr>
        @endif
    </table>
    <hr>
    <h4 class="titulo1"><b>Información de la referencia</b></h4>
    <hr>
    <div class="row">
      <div class="col-md-6 form-group">
          <label for="inputEmail3" class="col-sm-4 control-label">Institución:</label>
          <div class="col-sm-8">
            {!! Form::text("institucion",$estudio->institucion,["class"=>"form-control ", "readonly"=>"true"]); !!}
          </div>
          <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("numero_acta",$errors) !!}</p>
      </div>

      <div class="col-md-6 form-group">
         <label for="inputEmail3" class="col-sm-6 control-label"> ¿Estudio Actual? </label>
         <div class="col-sm-6">
         <label class="switchBtn">
            {!! Form::checkbox("estudio_actual",1,isset($referencia_estudio)?$referencia_estudio->estudio_actual:$estudio->estudio_actual,["class"=>"form-control estudio_actual","id"=>"estudio_actual"]); !!}
            <div class="slide"></div>
          </label>
         </div>
         <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("estudio_actual",$errors) !!}</p>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6 form-group">
         <label for="inputEmail3" class="col-sm-6 control-label"> ¿Solicitar referencia por correo? </label>
         <div class="col-sm-6">
         <label class="switchBtn">
            {!! Form::checkbox("solicitar_referencia",1,true,["class"=>"form-control solicitar_referencia","id"=>"solicitar_referencia"]); !!}
            <div class="slide"></div>
          </label>
         </div>
         <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("solicitar_referencia",$errors) !!}</p>
      </div>

      <div class="col-md-6 form-group ocultar_campo">
          <label for="inputEmail3" class="col-sm-4 control-label">Correos<span class="text-danger">*</span>:</label>
          <div class="col-sm-8">
            {!! Form::text("correos_institucion",null,["class"=>"form-control ", "placeholder"=>"Ingrese correos separados por coma", "id"=> "correos"]); !!}
            <span style="font-size:10pt;">Ingrese correos separados por coma</span>
          </div>
          <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("correos_institucion",$errors) !!}</p>
      </div>
    </div>

    <div class="row">
      <div class="col-md-6 form-group">
        <label for="inputEmail3" class="col-sm-4 control-label"> Fecha Inicio<span class="text-danger">*</span>:</label>
        <div class="col-sm-8">
          {!!Form::text("fecha_inicio",isset($referencia_estudio)?$referencia_estudio->fecha_inicio:$estudio->fecha_inicio,["class"=>"form-control ","id"=>"fecha_inicio", "readonly" => "readonly"]); !!}
        </div>
        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("fecha_inicio",$errors) !!}</p>
      </div>

      <div class="col-md-6 form-group ocultar">
        <label for="inputEmail3" class="col-sm-4 control-label"> Fecha Finalización<span class="text-danger">*</span>:</label>
        <div class="col-sm-8">
          {!!Form::text("fecha_finalizacion",isset($referencia_estudio)?$referencia_estudio->fecha_finalizacion:$estudio->fecha_finalizacion,["class"=>"form-control ","id"=>"fecha_finalizacion", "readonly" => "readonly"]);!!}
        </div>
        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("fecha_finalizacion",$errors) !!}</p>
      </div>

      <div class="form-group col-md-6">
        <label class="col-sm-4 control-label"> Nivel estudios<span class="text-danger">*</span>:</label>
        <div class="col-sm-8">
          {!! Form::select("nivel_estudio_id",$nivelEstudios,isset($referencia_estudio)?$referencia_estudio->nivel_estudio_id:$estudio->nivel_estudio_id,["class"=>"form-control","id"=>"nivel_estudio_id"]) !!}
        </div>
        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("nivel_estudio_id",$errors) !!}</p>
      </div>

      <div class="col-md-6 form-group">
        <label for="inputEmail3" class="col-sm-4 control-label">Programa <span class="text-danger">*</span> :</label>
         <div class="col-sm-8">
          {!! Form::text("programa",null,["class"=>"form-control", "id" => "programa"]); !!}
         </div>
        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("programa",$errors) !!}</p>
      </div>

      <div class="col-md-6 form-group">
          <label for="inputEmail3" class="col-sm-4 control-label">Acta:  </label>
          <div class="col-sm-8">
            {!! Form::text("numero_acta",isset($referencia_estudio)?$referencia_estudio->acta:$estudio->acta,["class"=>"form-control "]); !!}
          </div>
          <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("acta",$errors) !!}</p>
      </div>
      <div class="col-md-6 form-group">
          <label for="inputEmail3" class="col-sm-4 control-label">Folio:</label>
          <div class="col-sm-8">
            {!! Form::text("numero_folio",isset($referencia_estudio)?$referencia_estudio->folio:$estudio->folio,["class"=>"form-control "]); !!}
          </div>
          <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("folio",$errors) !!}</p>
      </div>

      <div class="col-md-6 form-group informacion_referencia hide">
         <label for="inputEmail3" class="col-sm-6 control-label"> Concepto de la referencia:</label>
         <div class="col-sm-6">
         <label class="switchBtn">
            {!! Form::checkbox("ratifica_informacion",1,null,["class"=>"form-control","id"=>"ratifica_informacion"]); !!}
            <div class="slide slide-apto"></div>
          </label>
         </div>
         <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("ratifica_informacion",$errors) !!}</p>
      </div>

      <div class="col-md-6 form-group informacion_referencia hide">
          <label for="inputEmail3" class="col-sm-4 control-label">Observaciones<span class="text-danger">*</span>:</label>
          <div class="col-sm-8">
            {!! Form::textarea("observaciones",null,["class"=>"form-control ", "id" => "observaciones"]); !!}
          </div>
          <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("observaciones",$errors) !!}</p>
      </div>
    </div>

    
    <div class="clearfix"></div>
  {!!Form::close()!!}
</div>
<div class="modal-footer">
  <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
  <button type="button" class="btn btn-success" id="guardar_nueva_referencia_estudio">Enviar</button>
</div>
<style>
.slide:after {
  content: "NO" !important;
}

input:checked + .slide:after {
  content: "SI" !important;
}

.slide-apto:after {
  content: "NO APTO" !important;
}

input:checked + .slide-apto:after {
  content: "APTO" !important;
}
</style>
<script>
  $(function(){

    @if( $estudio->estudio_actual == 1 )
      $('.ocultar').hide();
    @endif
          // $('.checkbox-preferencias').bootstrapSwitch();
    $("#fecha_inicio , #fecha_finalizacion ").datepicker(confDatepicker);
  });

  $(document).on('change','.estudio_actual',function(){
      if($(this).is(":checked")){
          //si elije q es empleo actual ocultar campo de salario
        $('.ocultar').hide();
      }else{
        $('.ocultar').show();
      }
  });

  $(document).on('change','.solicitar_referencia',function(){
      if($(this).is(":checked")){

        $('.ocultar_campo').show();
        $(".informacion_referencia").addClass('hide');
      }else{
        $('.ocultar_campo').hide();
        $(".informacion_referencia").removeClass('hide');
      }
  });

  $(".form-control").keydown(function(){
      $(this).css({"border": "1px solid #ccc"});
      $(this).siblings('.text').remove();
  });
</script>