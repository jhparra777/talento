 <div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <h4 class="modal-title">Gestionar referencia</h4>
 </div>

 <div class="modal-body">
    {!! Form::model((!empty($verificada))?$verificada:Request::all(),["id"=>"fr_referencia"]) !!}
    {!! Form::hidden("ref_id",null,["id"=>"ref_id"])!!}
    {!! Form::hidden("experiencia_id",$experiencia->id) !!}
    {!! Form::hidden("visita_candidato_id",$visita) !!}
     @if(!empty($verificada))
      {!! Form::hidden("verificada_id",$verificada->id) !!}
     @endif
     <hr>
    <h4 class="titulo1"><b>Información suministrada por el candidato</b></h4>
    <hr>
    <table class="table table-bordered tbl_info" style="margin-bottom: 0px">
       <tr>
        <th> Nombre Empresa </th>
        <td>{{$experiencia->nombre_empresa}}</td>
        @if($experiencia->telefono_temporal != "" && $experiencia->telefono_temporal != null)
          <th> Teléfono Empresa </th>
          <td>{{$experiencia->telefono_temporal}}</td>
        @endif
       </tr>
       <tr>
        <th>Ciudad</th>
        <td>{{$experiencia->ciudades}}</td>
        <th>Cargo Desempeñado</th>
        <td>{{$experiencia->cargo_especifico}}</td>
       </tr>
       
       <tr>
          @if( $experiencia->nombres_jefe != "" && $experiencia->nombres_jefe != null )
            <th>Nombres Jefe</th>
            <td>{{$experiencia->nombres_jefe}}</td>
          @endif
          @if( $experiencia->cargo_jefe != "" && $experiencia->cargo_jefe != null )
            <th>Cargo jefe</th>
            <td>{{$experiencia->cargo_jefe}}</td>
          @endif
       </tr>

       <tr>
         @if( $experiencia->movil_jefe != "" && $experiencia->movil_jefe != null )
          <th>Teléfono móvil Jefe</th>
          <td>{{$experiencia->movil_jefe}}</td>
        @endif
        @if($experiencia->fijo_jefe != "" && $experiencia->fijo_jefe != null)
          <th>Teléfono fijo jefe</th>
          <td>{{$experiencia->fijo_jefe}}</td>
        @endif
       </tr>
       <tr>
        <th>Trabajo Ingreso</th>
        <td>{{$experiencia->fecha_inicio}}</td>
        <th>Fecha Salida</th>
        <td>
          @if( $experiencia->empleo_actual == 1 )
            Empleo actual
          @else
            {{$experiencia->fecha_final}}
          @endif
        </td>
       </tr>
       <tr>
        {{--<th>Salario</th>
        <td>{{$experiencia->salario}}</td>--}}
        @if( $experiencia->desc_motivo != "" && $experiencia->desc_motivo != null )
          <th>Motivo Retiro</th>
          <td>{{$experiencia->desc_motivo}}</td>
        @endif
       </tr>
        <tr>
          @if( $experiencia->funciones_logros != "" && $experiencia->funciones_logros != null )
            <th>Funciones y logros</th>
            <td colspan="3">{{$experiencia->funciones_logros}}</td>
          @endif
        </tr>
        @if( $experiencia->certificados->count() > 0 )
          <tr>
            <th>
              Documentos adjuntos
            </th>

            <td colspan="3">
              <ul>
                  @foreach( $experiencia->certificados as $i => $certificado)
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
    <h4 class="titulo1"><b>Información del Referenciante</b></h4>
    <hr>
    <div class="row ">
      <div class="col-md-6 form-group">
        @if(route("home")=="https://gpc.t3rsc.co")
          <label for="inputEmail3" class="col-sm-4 control-label"> Persona que da referencias: </label>
        @else
          <label for="inputEmail3" class="col-sm-4 control-label"> Nombre Referenciante: </label>
        @endif
       
        <div class="col-sm-8">
         {!! Form::text("nombre_referenciante",null,["class"=>"form-control","id"=>"nombre_ref"]); !!}
        </div>
        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("nombre_referenciante",$errors) !!}</p>
      </div>
      
      <div class="col-md-6 form-group">
        <label for="inputEmail3" class="col-sm-4 control-label"> Cargo Referenciante: </label>
        <div class="col-sm-8">
         {!!Form::text("cargo_referenciante",null,["class"=>"form-control","id"=>"cargo_ref"]);!!}
        </div>
        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("cargo_referenciante",$errors) !!}</p>
      </div>

      <div class="col-md-12 form-group">
        <label for="inputEmail3" class="col-sm-6 control-label"> ¿Tiene algún vínculo familiar con el candidato?</label>
        <div class="col-sm-6">
          <label class="switchBtn">
            {!! Form::checkbox("vinculo_familiar","si",null,["class"=>"form-control checkbox-preferencias","id"=>"tiene_vinculo"]); !!}
            <div class="slide"></div>
         </label>
        </div>
        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("vinculo_familiar",$errors) !!}</p>
      </div>
      <div id="cual_vinculo" class="col-md-12 form-group hide">
        <label for="inputEmail3" class="col-sm-6 control-label"> ¿Cuál? </label>
        <div class="col-sm-12">
            {!! Form::textarea("vinculo_familiar_cual",null,["class"=>"form-control ","rows"=>2]); !!}
        </div>
        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("vinculo_familiar_cual",$errors) !!}</p>
      </div>

      @if(route('home') == "https://gpc.t3rsc.co" )

        <div class="col-md-6 form-group">
         <label for="inputEmail3" class="col-sm-4 control-label"> Relación laboral con candidato: </label>
         <div class="col-sm-8">
          {!! Form::text("relacion_laboral",null,["class"=>"form-control"]); !!}
         </div>
         <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("relacion_laboral",$errors) !!}</p>
        </div>

      @endif
    </div>
    <hr>
    <h4 class="titulo1"> <b>@if(route('home') != "https://gpc.t3rsc.co" ) Información de la referencia @else DATOS GENERALES @endif</b></h4>
    <hr>
    <div class="row">
     @if(route('home') != "https://gpc.t3rsc.co" )
      <div class="col-md-6 form-group">
        <label for="inputEmail3" class="col-sm-4 control-label"> Cargo desempeñado:  </label>
         <div class="col-sm-8">
          {!! Form::text("cargo2",null,["class"=>"form-control "]); !!}
         </div>
        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("cargo2",$errors) !!}</p>
      </div>

      <div class="col-md-6 form-group">
          <label for="inputEmail3" class="col-sm-5 control-label"> ¿Es el trabajo actual? </label>
            <div class="col-sm-7">
              <label class="switchBtn">
                {!! Form::checkbox("empleo_actual",1,null,["class"=>"form-control empleo_actual","id"=>"empleo_actual"]); !!}
                <div class="slide"></div>
              </label>
            </div>
           <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("empleo_actual",$errors) !!}</p>
      </div>
      {{--
      <div class="col-md-6 form-group">
        <label for="inputEmail3" class="col-sm-4 control-label"> Dirección de la empresa:  </label>
         <div class="col-sm-8">
          {!! Form::text("direccion_empresa",null,["class"=>"form-control "]); !!}
         </div>
        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("direccion_empresa",$errors) !!}</p>
      </div>
      <div class="col-md-6 form-group">
          <label for="inputEmail3" class="col-sm-4 control-label"> Tipo de contrato:  </label>
          <div class="col-sm-8">
            {!! Form::text("tipo_contrato",null,["class"=>"form-control "]); !!}
          </div>
          <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("tipo_contrato",$errors) !!}</p>
      </div>
      --}}
      </div>
      <div class="row">
      <div class="col-md-6 form-group">
        <label for="inputEmail3" class="col-sm-4 control-label"> Fecha Inicio   </label>
        <div class="col-sm-8">
          {!!Form::text("fecha_inicio",null,["class"=>"form-control ","id"=>"fecha_inicio", "readonly" => "readonly"]); !!}
        </div>
        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("fecha_inicio",$errors) !!}</p>
      </div>

      <div class="col-md-6 form-group ocultar">
        <label for="inputEmail3" class="col-sm-4 control-label"> Fecha Retiro </label>
        <div class="col-sm-8">
          {!!Form::text("fecha_retiro",null,["class"=>"form-control ","id"=>"fecha_retiro", "readonly" => "readonly"]);!!}
        </div>
        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("fecha_retiro",$errors) !!}</p>
      </div>
      </div>
      <div class="row">

      <div class="col-md-6 form-group ocultar">
       <label for="inputEmail3" class="col-sm-4 control-label"> Motivo de Retiro: </label>
        <div class="col-sm-8">
         {!! Form::select("motivo_retiro_id",$motivo_retiro,null,["class"=>"form-control"]); !!}
        </div>
         <p class="error text-danger direction-botones-center"> {!! FuncionesGlobales::getErrorData("motivo_retiro_id",$errors) !!} </p>
      </div>

      <div class="col-md-12 form-group ocultar">
         <label for="inputEmail3" class="col-sm-4 control-label"> Observaciones sobre el motivo:</label>
          <div class="col-sm-12">
           {!! Form::textarea("observaciones",null,["class"=>"form-control","rows"=>2]); !!}
          </div>
         <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("observaciones",$errors) !!}</p>
      </div>

        <div class="col-md-6 form-group">
            <label for="inputEmail3" class="col-sm-6 control-label"> ¿Tiene anotaciones en la hoja de vida? </label>
            <div class="col-sm-6">
             <label class="switchBtn">
              {!! Form::checkbox("anotacion_hv","si",null,["class"=>"form-control checkbox-preferencias","id"=>"anotacion_hv"]); !!}
              <div class="slide"></div>
             </label>

            </div>
            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("anotacion_hv",$errors) !!}</p>
        </div>
        <div id="cuales_anotaciones" class="col-md-12 form-group hide">
         <label for="inputEmail3" class="col-sm-6 control-label"> ¿Cuáles?</label>
            <div class="col-sm-12">
             {!!Form::textarea("cuales_anotacion",null,["class"=>"form-control ","rows"=>2]);!!}

            </div>
            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("cuales_anotacion",$errors) !!}</p>
        </div>
     @else

      <div class="col-md-6 form-group">
       <label for="inputEmail3" class="col-sm-12 control-label"> Tiempo que trabajaron juntos: </label>
        <div class="col-sm-12">
          {!!Form::text("tiempo_juntos",null,["class"=>"form-control "]); !!}
        </div>
        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("tiempo_juntos",$errors) !!}</p>
      </div>

      <div class="col-md-6 form-group">
       <label for="inputEmail3" class="col-sm-12 control-label"> Cargos ocupados: </label>
        <div class="col-sm-12">
         {!! Form::text("cargo2",null,["class"=>"form-control "]); !!}
        </div>
        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("cargo2",$errors) !!}</p>
      </div>

    @endif

    </div>
    
    <div class="row">
       @if(route('home') != "https://gpc.t3rsc.co" )

        <div class="col-md-6 form-group">
         <label for="inputEmail3" class="col-sm-6 control-label"> ¿Tuvo personas a cargo? </label>
          <div class="col-sm-6">
           <label class="switchBtn">
           {!! Form::checkbox("personas_cargo","si",null,["class"=>"form-control checkbox-preferencias","id"=>"personas_cargo"]); !!}
            <div class="slide"></div>
           </label>
            </div>
          <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("personas_cargo",$errors) !!}
            </p>
        </div>

        <div id="cuantas_personas_cargo" class="col-md-6 form-group hide">
         <label for="inputEmail3" class="col-sm-4 control-label"> ¿Cuantas? </label>
            <div class="col-sm-8">
             {!! Form::text("cuantas_personas",null,["class"=>"form-control solo_numeros "]); !!}
            </div>
          <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("cuantas_personas",$errors) !!}</p>
        </div>
      @else

       <div class="col-md-12 form-group">
        <label for="inputEmail3" class="col-sm-12 control-label">¿Cómo describiría el desempeño general del candidato y cuales considera sus fortalezas personales y profesionales? </label>
          <div class="col-sm-12">
           {!! Form::textarea("desempenio_candidato",null,["class"=>"form-control","rows"=>2]); !!}
          </div>
         <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("observaciones",$errors) !!}</p>
        </div>

        <div class="col-md-12 form-group">
        <label for="inputEmail3" class="col-sm-12 control-label">¿Podría comentarme sobre las habilidades o conocimientos que usted considera debe reforzar para potenciar su desempeño?</label>
          <div class="col-sm-12">
           {!! Form::textarea("reforzar_desempenio",null,["class"=>"form-control","rows"=>2]); !!}
          </div>
         <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("reforzar_desempenio",$errors) !!}</p>
        </div>

        <div class="col-md-12 form-group">
        <label for="inputEmail3" class="col-sm-12 control-label">¿Cuáles reconocería como sus mayores logros?</label>
          <div class="col-sm-12">
           {!! Form::textarea("mayores_logros",null,["class"=>"form-control","rows"=>2]); !!}
          </div>
         <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("mayores_logros",$errors) !!}</p>
        </div>

        <div class="col-md-12 form-group">
         <label for="inputEmail3" class="col-sm-12 control-label">¿Cómo era la relación que mantenía con su/s jefe/s, compañeros y colaboradores?</label>
          <div class="col-sm-12">
           {!! Form::textarea("relacion_companieros",null,["class"=>"form-control","rows"=>2]);!!}
          </div>
         <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("relacion_companieros",$errors) !!}</p>
        </div>
      @endif
    </div>
    <hr>
    <h4 class="titulo1"><b>Concepto Final</b></h4>
    <hr>
    <div class="row">
      <div class="col-md-6 form-group">
         <label for="inputEmail3" class="col-sm-6 control-label"> ¿Es adecuado para el cargo? </label>
         <div class="col-sm-6">
         <label class="switchBtn">
           <input type="checkbox" name="adecuado" value="adecuado" class="from-control" id="adecuado" @if( isset($verificada) && $verificada->adecuado == 'adecuado') checked @endif>
            <div class="slide"></div>
          </label>
         </div>
         <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("adecuado",$errors) !!}</p>
      </div>
    </div>
    <div class="row">
     <div class="col-md-6 form-group">
      @if(route("home")=="https://gpc.t3rsc.co")
          <label for="inputEmail3" class="col-sm-6 control-label"> ¿De tener oportunidad volvería a trabajar con él/ella?</label>
      @else
          <label for="inputEmail3" class="col-sm-6 control-label">¿Volvería a contratarlo?</label>
      @endif
     
      <div class="col-sm-6">
       <label class="switchBtn">
        {!! Form::checkbox("volver_contratarlo","si",(!empty($verificada))?$verificada->volver_contratarlo:"si",["class"=>"form-control checkbox-preferencias","id"=>"switch"]); !!}
        <div class="slide"></div>
       </label>
      </div>
       <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("volver_contratarlo",$errors) !!}</p>
     </div>
      
      @if(route('home') != "https://gpc.t3rsc.co" )
      
        <div class="col-md-12 form-group">
         <label for="inputEmail3" class="col-sm-6 control-label"> ¿Por qué? </label>
         <div class="col-sm-12">
          {!! Form::textarea("porque_obj",null,["class"=>"form-control ","rows"=>2]); !!}
         </div>
         <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("porque_obj",$errors) !!}</p>
        </div>

        <div class="col-md-12 form-group">
         <label for="inputEmail3" class="col-sm-6 control-label"> Observaciones generales de la referencia:  </label>
          <div class="col-sm-12">
           {!!Form::textarea("observaciones_referencias",null,["class"=>"form-control","rows"=>2]);!!}
          </div>
         <p class="error text-danger direction-botones-center">{!!FuncionesGlobales::getErrorData("observaciones_referencias",$errors)!!}</p>
        </div>

     @endif
    
    </div>
    <div class="clearfix"></div>
  {!!Form::close()!!}
</div>
<div class="modal-footer">
  <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
  <button type="button" class="btn btn-success" id="guardar_nueva_referencia">Guardar</button>
</div>
<style>
.slide:after {
  content: "NO" !important;
}

input:checked + .slide:after {
  content: "SI" !important;
}
</style>
<script>
 $(function(){

  @if( $verificada->empleo_actual == 1 )
    $('.ocultar').hide();
  @endif

  @if( $verificada->vinculo_familiar == 'si' )
    $('#cual_vinculo').removeClass('hide');
   @endif

   @if( $verificada->anotacion_hv == 'si' )
      $('#cuales_anotaciones').removeClass('hide');
   @endif

   @if( $verificada->personas_cargo == 'si' )
    $('#cuantas_personas_cargo').removeClass('hide');
   @endif
        // $('.checkbox-preferencias').bootstrapSwitch();
  $("#fecha_inicio, #fecha_retiro").datepicker(confDatepicker);

  $(document).on('change','#tiene_vinculo',function(){
      if($(this).is(":checked")){
          //si elije q es empleo actual ocultar campo de salario
        $('#cual_vinculo').removeClass('hide');
      }else{
        $('#cual_vinculo').addClass('hide');
      }
  });

  $(document).on('change','#anotacion_hv',function(){
      if($(this).is(":checked")){
          //si elije q es empleo actual ocultar campo de salario
        $('#cuales_anotaciones').removeClass('hide');
      }else{
        $('#cuales_anotaciones').addClass('hide');
      }
  });

  $(document).on('change','#personas_cargo',function(){
      if($(this).is(":checked")){
          //si elije q es empleo actual ocultar campo de salario
        $('#cuantas_personas_cargo').removeClass('hide');
      }else{
        $('#cuantas_personas_cargo').addClass('hide');
      }
  });
 });
</script>