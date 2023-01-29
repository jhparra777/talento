<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title">Enviar a contratación  Masivo</h4>
</div>
<div class="modal-body">
    {!! Form::model(Request::all(),["id"=>"fr_contratar_masivo_req"]) !!}
    
    <h3>Datos de contratación</h3>
     
      @foreach($req_candidato_id as $req_c_id)
       {!! Form::hidden("req_candi_id[]",$req_c_id); !!}
      @endforeach()
     

    <div class="col-md-6 form-group">
        <label for="inputEmail3" class="control-label"> Fecha Ingreso* </label>
        {!! Form::text ("fecha_inicio_contrato",null,["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus
        tri-transition-300","id"=>"fecha_inicio_contratos"]); !!}

        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("fecha_inicio_contrato",$errors) !!}</p>
    </div>

    <div class="col-md-6 form-group">
        <label for="inputEmail3" class="control-label"> Centro de costos* </label>
        {!! Form::text("centro_costos",null,["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus
        tri-transition-300"]); !!}

        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("observaciones",$errors) !!}</p>
    </div>

    <div class="col-md-12 form-group">
        <label for="inputEmail3" class="control-label"> Observaciones* </label>
        {!! Form::textarea("observaciones",null,["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus
        tri-transition-300","rows"=>'2']); !!}

        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("observaciones",$errors) !!}</p>
    </div>

    <div class="col-md-12 form-group">
        @if(route("home") == "http://komatsu.t3rsc.co" || route("home") == "https://komatsu.t3rsc.co")
            <label for="inputEmail3" class="control-label">Quién autorizó * </label>
        @else
            <label for="inputEmail3" class="control-label">Quién autorizó por parte del cliente* </label>
        @endif
            {!! Form::select ("user_autorizacion",$usuarios_clientes,$user_id,["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus
            tri-transition-300"]); !!}

        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("user_autorizacion",$errors) !!}</p>
    </div>
    
  
    {!! Form::close() !!}


    <div class="clearfix"></div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default | tri-px-2 tri-br-2 tri-border--none tri-transition-200" data-dismiss="modal">Cerrar</button>

    <button type="button" class="btn btn-success | tri-px-2 tri-br-2 tri-border--none tri-transition-300 tri-green" id="confirmar_contratacion_masivo" >Confirmar</button>

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
