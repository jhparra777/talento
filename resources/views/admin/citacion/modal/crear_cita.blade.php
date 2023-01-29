<!-- Inicio contenido principal -->
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title">Nueva Cita</h4>
</div>

@if(route("home")=="http://temporizar.t3rsc.co" || route("home")=="https://temporizar.t3rsc.co" || route("home")=="http://demo.t3rsc.co" || route("home")=="https://demo.t3rsc.co" || route("home")=="http://localhost:8000")

    <div class="modal-body">
        {!! Form::model(Request::all(),["id"=>"fr_cita"]) !!}

            <div class="col-md-12" id="mensaje-resultado">
                <div class="alert alert-warning alert-dismissible" role="alert">
                    @if (isset($single))
                        <p>Cita para  <b>{{(empty($candidato))?'':$candidato->name}}</b></p>
                    @else
                        <p>Cita masiva  <b></b></p>
                    @endif
                </div>
            </div>

            <div class="col-md-12 form-group">
                <label for="inputEmail3" class="col-sm-4 control-label">Psicologos</label>
                
                <div class="col-sm-12">
                    {!! Form::select("psicologo",$psicologos,null,["class"=>"form-control ","id"=>""]); !!}
                </div>

                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("psicologo_id",$errors) !!}</p>
            </div>

            <div class="col-md-12 form-group">
                <label for="inputEmail3" class="col-sm-4 control-label">Motivo Cita</label>

                <div class="col-sm-12">
                    {!! Form::select("motivo",$motivo,null,["class"=>"form-control ","id"=>""]); !!}
                </div>

                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("motivo_id",$errors) !!}</p>
            </div>

            <div class="col-md-12 form-group">
                <label for="inputEmail3" class="col-sm-4 control-label">Observaciones</label>
                <div class="col-sm-12">
                    {!! Form::textarea("observaciones",null,["class"=>"form-control ","id"=>"observaciones","rows"=>"2"]); !!}
                </div>
                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("observaciones",$errors) !!}</p>
            </div>

            <div class="col-md-6">
                <label for="inputEmail3" class="col-sm-3 control-label"> Fecha Cita </label>

                <div class="col-sm-6">
                    {!! Form::text ("fecha_cita",null,["class"=>"form-control","id"=>"fecha_cita"]); !!}
                </div>

                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("fecha_inicio_contrato",$errors) !!}</p>
            </div>

            {{-- <div class="col-md-4">
                <label for="inputEmail3" class="col-sm-3 control-label">Req:</label>

                {!! Form::select("req_id",$requerimientos,null,["class"=>"form-control chosen1" ]); !!}

                <br>
                <p class="text-danger">{!! FuncionesGlobales::getErrorData("req_id",$errors) !!}</p>
            </div> --}}

            {!! Form::hidden("candidatoId", $candidatoId); !!}
            {!! Form::hidden("candidatoReq", $candidatoReq); !!}

            @if (isset($single))
                {!! Form::hidden("single", $single); !!}
            @endif

            <div class="clearfix"></div> 
            <div class="clearfix"></div>

            <br><br>

            <div class="clearfix"></div>

        {!! Form::close() !!}
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-success" id="guardar_cita" >Guardar</button>
    </div>

    <style>
        .chosen1{ width: 100px !important; }
    </style>

@else

    <div class="modal-body">
        {!! Form::model(Request::all(),["id"=>"fr_cita"]) !!}
        <div class="col-md-12" id="mensaje-resultado">
        <div class="alert alert-warning alert-dismissible" role="alert">

            <p>Cita para  <b>{{$candidato->name}}</b></p>
            
        </div>
        </div>
             <div class="col-md-12 form-group">
                <label for="inputEmail3" class="col-sm-4 control-label">Psicologos</label>
                <div class="col-sm-12">
                    {!! Form::select("psicologo",$psicologos,null,["class"=>"form-control ","id"=>""]); !!}
                </div>
                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("psicologo_id",$errors) !!}</p>
            </div>

            <div class="col-md-12 form-group">
                <label for="inputEmail3" class="col-sm-4 control-label">Motivo Cita</label>
                <div class="col-sm-12">
                    {!! Form::select("motivo",$motivo,null,["class"=>"form-control ","id"=>""]); !!}
                </div>
                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("motivo_id",$errors) !!}</p>
            </div>

             <div class="col-md-12 form-group">
                <label for="inputEmail3" class="col-sm-4 control-label">Observaciones</label>
                <div class="col-sm-12">
                    {!! Form::textarea("observaciones",null,["class"=>"form-control ","id"=>"observaciones","rows"=>"2"]); !!}
                </div>
                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("observaciones",$errors) !!}</p>
            </div>
           
               
               
        
            <div class="col-md-6">
                <label for="inputEmail3" class="col-sm-3 control-label"> Fecha Cita </label>
            <div class="col-sm-6">

                {!! Form::text ("fecha_cita",null,["class"=>"form-control","id"=>"fecha_cita"]); !!}
            </div>
            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("fecha_inicio_contrato",$errors) !!}</p>
            </div>
            <div class="col-md-4">
                <label for="inputEmail3" class="col-sm-3 control-label">Req:</label>
            {!! Form::select("req_id",$requerimientos,null,["class"=>"form-control chosen1" ]); !!}
            <br>
            <p class="text-danger">{!! FuncionesGlobales::getErrorData("req_id",$errors) !!}</p>
            </div>    
          
             {!! Form::hidden("user_id",$candidato->user_id); !!}
            
        
     <div class="clearfix"></div> 
        

       

        <div class="clearfix"></div>

        <br><br>
        
        
           

        <div class="clearfix"></div>
        {!! Form::close() !!}
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-success" id="guardar_cita" >Guardar</button>

    </div>
    <style >
        


    .chosen1{
        width: 100px !important;

    </style>

@endif

<script>
$(function() {
    
    $(".chosen1").chosen();

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