
<!-- Inicio contenido principal -->
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title">Editar Cita</h4>
</div>
<div class="modal-body">
    {!! Form::model(Request::all(),["id"=>"fr_act_cita"]) !!}
    <div class="col-md-12" id="mensaje-resultado">
    <div class="alert alert-warning alert-dismissible" role="alert">

        @if (isset($candidato->name))
            <p>Cita para  <b>{{(empty($candidato))?'':$candidato->name}}</b></p>
        @else
            <p>Cita para  <b></b></p>
        @endif        
        
    </div>
</div>
         <div class="col-md-12 form-group">
            <label for="inputEmail3" class="col-sm-4 control-label">Psicologos</label>
            <div class="col-sm-12">
                {!! Form::select("psicologo",$psicologos,$psicologo_id,["class"=>"form-control ","id"=>""]); !!}
            </div>
            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("psicologo_id",$errors) !!}</p>
        </div>

        <div class="col-md-12 form-group">
            <label for="inputEmail3" class="col-sm-4 control-label">Motivo Cita</label>
            <div class="col-sm-12">
                {!! Form::select("motivo",$motivo,$motivo_id,["class"=>"form-control ","id"=>""]); !!}
            </div>
            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("motivo_id",$errors) !!}</p>
        </div>

         <div class="col-md-12 form-group">
            <label for="inputEmail3" class="col-sm-4 control-label">Observaciones</label>
            <div class="col-sm-12">
                {!! Form::textarea("observaciones",$cita->observaciones,["class"=>"form-control ","id"=>"observaciones","rows"=>"2"]); !!}
            </div>
            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("observaciones",$errors) !!}</p>
        </div>

        <div class="col-md-8 form-group">
        <label for="inputEmail3" class="col-sm-3 control-label"> Fecha Cita </label>
        <div class="col-sm-4">

            {!! Form::text ("fecha_cita",$cita->fecha_cita,["class"=>"form-control","id"=>"fecha_cita"]); !!}
        </div>
        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("fecha_inicio_contrato",$errors) !!}</p>
    </div>

          {!! Form::hidden("cita_id",$cita->id); !!}
    
 <div class="clearfix"></div> 
    

   

    <div class="clearfix"></div>

    <br><br>
    
    
       

    <div class="clearfix"></div>
    {!! Form::close() !!}
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
    <button type="button" class="btn btn-success" id="actualizar_cita" >Actualizar</button>

</div>

<script>
$(function() {
  $('#fecha_cita').daterangepicker({
    "singleDatePicker": true,
    "timePicker": true,
    
   "minDate": moment(),
     "opens": "left",
    locale: {
      format: 'YYYY/MM/DD hh:mm A',
       "applyLabel": "Aplicar",
        "cancelLabel": "Cancelar",
        "autoApply": true,
      "daysOfWeek": [
            "Dom",
            "Lun",
            "Mar",
            "Mier",
            "Jue",
            "Vie",
            "Sa"
        ],
        "monthNames": [
            "Enero",
            "Febrero",
            "Marzo",
            "Abril",
            "Mayo",
            "Junio",
            "Julio",
            "Augosto",
            "Septiembre",
            "Octubre",
            "Noviembre",
            "Diciembre"
        ]
    }
});
});
</script>