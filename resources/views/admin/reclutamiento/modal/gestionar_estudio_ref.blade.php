 <div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <h4 class="modal-title">Gestionar referencia</h4>
 </div>

 <div class="modal-body">
    {!! Form::model((!empty($verificada))?$verificada:Request::all(),["id"=>"fr_estudio"]) !!}
    {!! Form::hidden("ref_id",null,["id"=>"ref_id"])!!}
    {!! Form::hidden("estudios_id",$estudio->id) !!}
    {!! Form::hidden("visita_candidato_id",$visita) !!}
     @if(!empty($verificada))
      {!! Form::hidden("verificada_id",$verificada->id) !!}
     @endif
    <h4 class="titulo1">Informacion suministrada por el candidato</h4>
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
        <th>Fecha finalización</th>
        <td>{{$estudio->fecha_finalizacion}}</td>
       </tr>
       <tr>
         <th>Ciudad</th>
         <td>{{$estudio->ciudad}}</td>
       </tr>
       
       
    </table>
    <h4 class="titulo1">Información del Referenciante </h4>
    <div class="row ">
      <div class="col-md-6 form-group">
        @if(route("home")=="https://gpc.t3rsc.co")
          <label for="inputEmail3" class="col-sm-4 control-label"> Persona que da referencias: </label>
        @else
          <label for="inputEmail3" class="col-sm-4 control-label"> Nombre Referenciante: </label>
        @endif
       
        <div class="col-sm-8">
         {!! Form::text("nombre_referenciante",null,["class"=>"form-control","id"=>"nombre_ref","required"=>true]); !!}
        </div>
        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("nombre_referenciante",$errors) !!}</p>
      </div>
      
      <div class="col-md-6 form-group">
        <label for="inputEmail3" class="col-sm-4 control-label"> Cargo Referenciante: </label>
        <div class="col-sm-8">
         {!!Form::text("cargo_referenciante",null,["class"=>"form-control","id"=>"cargo_ref","required"=>true]);!!}
        </div>
        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("cargo_referenciante",$errors) !!}</p>
      </div>

     
    </div>

    <h4 class="titulo1"> @if(route('home') != "https://gpc.t3rsc.co" ) Información de la referencia @else DATOS GENERALES @endif</h4>
    <div class="row">
    
     <div class="col-md-6 form-group">
        <label for="inputEmail3" class="col-sm-4 control-label">Número de acta:  </label>
         <div class="col-sm-8">
          {!! Form::text("numero_acta",null,["class"=>"form-control "]); !!}
         </div>
        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("numero_acta",$errors) !!}</p>
    </div>
    <div class="col-md-6 form-group">
        <label for="inputEmail3" class="col-sm-4 control-label"> No. Folio</label>
         <div class="col-sm-8">
          {!! Form::text("numero_folio",null,["class"=>"form-control "]); !!}
         </div>
        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("numero_folio",$errors) !!}</p>
    </div>
      <div class="col-md-6 form-group">
        <label for="inputEmail3" class="col-sm-4 control-label"> No. Registro:  </label>
         <div class="col-sm-8">
          {!! Form::text("numero_registro",null,["class"=>"form-control"]); !!}
         </div>
        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("numero_registro",$errors) !!}</p>
      </div>

        <div class="col-md-12 form-group">
            <label for="inputEmail3" class="col-sm-12 control-label">Observaciones</label>
            <div class="col-sm-12">
             {!!Form::TEXTAREA("observaciones",null,["class"=>"form-control ","id"=>"fecha_inicio","rows"=>5]); !!}
            </div>
           <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("observaciones",$errors) !!}</p>
        </div>

    </div>

    
    <div class="clearfix"></div>
  {!!Form::close()!!}
</div>
<div class="modal-footer">
  <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
  <button type="button" class="btn btn-success" id="guardar_nuevo_estudio">Guardar</button>
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
        // $('.checkbox-preferencias').bootstrapSwitch();
  $("#fecha_inicio , #fecha_retiro ").datepicker(confDatepicker);
 });
</script>