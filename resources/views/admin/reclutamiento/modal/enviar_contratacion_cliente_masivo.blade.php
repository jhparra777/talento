<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title">Enviar a contratación  Masivo
</div>
<div class="modal-body">
    {!! Form::model(Request::all(),["id"=>"fr_contratar_masivo_req"]) !!}
    
    <h3>Datos de contratación</h3>
     {{-- {{ dd($contra_clientes) }} --}}
     
      @foreach($req_candidato_id as $req_c_id)
       {!! Form::hidden("req_candi_id[]",$req_c_id); !!}
      @endforeach()
     

    <div class="col-md-12 form-group">
        <label for="inputEmail3" class="col-sm-4 control-label"> Fecha Ingreso* </label>
        <div class="col-sm-8">
            {!! Form::text ("fecha_inicio_contrato",null,["class"=>"form-control","id"=>"fecha_inicio_contratos"]); !!}
        </div>
        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("fecha_inicio_contrato",$errors) !!}</p>
    </div>

  
    {{-- <div class="col-md-12 form-group">
        <label for="inputEmail3" class="col-sm-4 control-label"> Fecha Retiro* </label>
        <div class="col-sm-8">

            {!! Form::text ("fecha_fin_contrato",null,["class"=>"form-control","id"=>"fecha_fin_contrato"]); !!}
        </div>
        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("fecha_fin_contrato",$errors) !!}</p>
    </div> --}}

    <div class="col-md-12 form-group">
        <label for="inputEmail3" class="col-sm-4 control-label"> Centro de costos* </label>
        <div class="col-sm-8">

            {!! Form::text("centro_costos",null,["class"=>"form-control"]); !!}
        </div>
        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("observaciones",$errors) !!}</p>
    </div>
    <div class="col-md-12 form-group">
        <label for="inputEmail3" class="col-sm-4 control-label"> Observaciones* </label>
        <div class="col-sm-8">

            {!! Form::textarea("observaciones",null,["class"=>"form-control","rows"=>'2']); !!}
        </div>
        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("observaciones",$errors) !!}</p>
    </div>
    <div class="col-md-12 form-group">
        @if(route("home") == "http://komatsu.t3rsc.co" || route("home") == "https://komatsu.t3rsc.co")
            <label for="inputEmail3" class="col-sm-4 control-label">Quién autorizó * </label>
        @else
            <label for="inputEmail3" class="col-sm-4 control-label">Quién autorizó por parte del cliente* </label>
        @endif
        <div class="col-sm-8">

            {!! Form::select ("user_autorizacion",$usuarios_clientes,$user_id,["class"=>"form-control"]); !!}
        </div>
        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("user_autorizacion",$errors) !!}</p>
    </div>
    
  
    {!! Form::close() !!}


    <div class="clearfix"></div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>

    <button type="button" class="btn btn-success" id="confirmar_contratacion_masivo" >Confirmar</button>

</div>
<script>
    $(function () {
var confDatepicker = {
    altFormat: "yy-mm-dd",
    dateFormat: "yy-mm-dd",
    changeMonth: true,
    changeYear: true,
    buttonImage: "img/gifs/018.gif",
    buttonImageOnly: true,
    autoSize: true,
    dayNames: ["Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado"],
    monthNamesShort: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
    dayNamesMin: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],
    yearRange: "1930:2050"
};
        
        $("#fecha_fin_contrato, #fecha_inicio_contratos").datepicker(confDatepicker);
    });
</script>
